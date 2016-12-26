<?php

namespace common\modules\order\controllers;

use Yii;

class MyOrderController extends OrderController
{
    public $indexTitle = 'Сделки, заключенные мной';

    public function getViewPath()
    {
        return Yii::getAlias('@common/modules/order/views/order');
    }

    public function actionIndex()
    {
        $model = $this->_getSearchClassName();

        $searchModel = new $model();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, [], true);

        return $this->render(
            'index',
            [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }
}
