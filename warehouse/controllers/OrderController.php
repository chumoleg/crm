<?php

namespace warehouse\controllers;

use common\components\controllers\CrudController;
use common\models\order\OrderSearch;
use warehouse\forms\OrderForm;

class OrderController extends CrudController
{
    protected function _getSearchClassName()
    {
        return OrderSearch::className();
    }

    protected function _getModelById($id)
    {
        return OrderForm::findById($id);
    }

    protected function _getFormClassName()
    {
        return OrderForm::className();
    }
}
