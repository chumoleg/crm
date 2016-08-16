<?php

namespace common\commands;

use Yii;
use common\models\clientBaseFile\ClientBaseFile;
use common\models\clientBaseFile\ClientBaseFileData;
use common\components\Status;
use common\models\order\OrderStage;
use yii\console\Controller;

class OrderController extends Controller
{
    public $clientFileName;
    public $serverFileName;

    public function options($actionID)
    {
        return array_merge(
            parent::options($actionID),
            ['clientFileName', 'serverFileName']
        );
    }

    public function actionCheckOverdue()
    {
        $orderStages = OrderStage::find()
            ->select(['id'])
            ->andWhere(['order_stage.status' => Status::STATUS_ACTIVE])
            ->andWhere('order_stage.time_limit > 0')
            ->asArray()
            ->all();

        foreach ($orderStages as $item) {
            $orderStage = OrderStage::findById($item['id']);
            $orderStage->setTimeSpent();
            $orderStage->save();
        }
    }

    public function actionLoadFromFile()
    {
        if (empty($this->serverFileName)) {
            return;
        }

        $file = Yii::$app->getRuntimePath() . '/' . $this->serverFileName;
        if (!is_readable($file)) {
            unlink($file);
            return;
        }

        try {
            $parsedData = \moonland\phpexcel\Excel::import($file, ['setFirstRecordAsKeys' => false]);
            if (empty($parsedData)) {
                unlink($file);
                return;
            }
        } catch (\Exception $e) {
            unlink($file);
            return;
        }

        $fileModel = new ClientBaseFile();
        $fileModel->client_name = $this->clientFileName;
        $fileModel->server_name = $this->serverFileName;
        $fileModel->save();

        $countSaved = 0;
        foreach ($parsedData as $item) {
            $fio = $item['A'];
            $phone = $item['B'];
            unset($item['A']);
            unset($item['B']);

            $rel = new ClientBaseFileData();
            $rel->client_base_file_id = $fileModel->id;
            $rel->fio = $fio;
            $rel->phone = $phone;
            $rel->data = $item;
            $rel->save();

            if ($rel->id) {
                $countSaved++;
            }
        }

        if (empty($countSaved)) {
            $fileModel->delete();
        }

        unlink($file);
    }
}