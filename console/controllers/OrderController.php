<?php

namespace common\commands;

use Yii;
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
}