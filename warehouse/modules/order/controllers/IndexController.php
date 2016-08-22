<?php

namespace warehouse\modules\order\controllers;

use common\components\controllers\CrudController;
use warehouse\models\order\Order;
use common\models\order\OrderSearch;
use common\forms\CreateOrderForm;

class IndexController extends CrudController
{
    protected function _getSearchClassName()
    {
        return OrderSearch::className();
    }

    protected function _getModelById($id)
    {
        return Order::findById($id);
    }

    protected function _getFormClassName()
    {
        return CreateOrderForm::className();
    }
}
