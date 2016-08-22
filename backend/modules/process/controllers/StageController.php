<?php

namespace backend\modules\process\controllers;

use Yii;
use common\components\controllers\CrudController;
use common\models\stage\StageSearch;
use backend\modules\process\forms\StageForm;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class StageController extends CrudController
{
    protected function _getSearchClassName()
    {
        return StageSearch::className();
    }

    protected function _getFormClassName()
    {
        return StageForm::className();
    }

    /**
     * @param $id
     *
     * @return null|StageForm
     * @throws NotFoundHttpException
     */
    protected function _getModelById($id)
    {
        $model = StageForm::findById($id);
        if (empty(Yii::$app->request->post())) {
            $model->methodData = ArrayHelper::getColumn($model->stageMethods, 'method');
        }

        return $model;
    }
}
