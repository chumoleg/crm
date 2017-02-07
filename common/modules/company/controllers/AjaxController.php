<?php

namespace common\modules\company\controllers;

use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use common\components\controllers\BaseController;
use common\models\company\Company;

class AjaxController extends BaseController
{
    public function init()
    {
        if (!Yii::$app->request->isAjax) {
            throw new ForbiddenHttpException('Access denied');
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        parent::init();
    }

    public function actionChangeOperatorByItems()
    {
        $operator = (int)Yii::$app->request->post('operator');
        $items = Yii::$app->request->post('items');
        if (empty($operator)) {
            return ['error' => 'Выберите оператора'];
        }

        if (empty($items) || !is_array($items)) {
            return ['error' => 'Выберите контакты'];
        }

        Company::updateAll(['current_operator' => $operator], 'id IN (' . implode(',', $items) . ' )');

        return true;
    }

    public function actionChangeOperatorFromTo()
    {
        $fromOperator = (int)Yii::$app->request->post('fromOperator');
        $toOperator = (int)Yii::$app->request->post('toOperator');
        if (empty($fromOperator) || empty($toOperator)) {
            return ['error' => 'Выберите операторов'];
        }

        Company::updateAll(['current_operator' => $toOperator], 'current_operator = ' . $fromOperator);

        return true;
    }
}
