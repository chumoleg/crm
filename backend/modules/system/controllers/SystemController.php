<?php

namespace backend\modules\management\modules\system\controllers;

use Yii;
use common\models\system\SystemUrl;
use common\components\controllers\CrudController;
use common\models\system\SystemSearch;
use common\models\system\SystemStage;
use backend\modules\management\modules\system\forms\SystemForm;

class SystemController extends CrudController
{
    public function actionManage($id)
    {
        $this->loadModel($id);
        return $this->render('manage');
    }

    public function actionEditableStage($system, $stage)
    {
        $model = SystemStage::getModelBySystemAndStage($system, $stage);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (isset($_POST['hasEditable'])) {
            $model->foreign_status = Yii::$app->request->post('foreign_status');
            if ($model->save()) {
                return ['output' => $model->foreign_status, 'message' => ''];
            }
        }

        return ['output' => '', 'message' => ''];
    }

    public function actionEditableUrl($system, $type)
    {
        $model = SystemUrl::getModelBySystemAndType($system, $type);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (isset($_POST['hasEditable'])) {
            $model->url = Yii::$app->request->post('url');
            if ($model->save()) {
                return ['output' => $model->url, 'message' => ''];
            }
        }

        return ['output' => '', 'message' => ''];
    }

    protected function _getSearchClassName()
    {
        return SystemSearch::className();
    }

    protected function _getModelById($id)
    {
        return SystemForm::findById($id);
    }

    protected function _getFormClassName()
    {
        return SystemForm::className();
    }
}
