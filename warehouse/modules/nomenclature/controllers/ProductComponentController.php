<?php

namespace warehouse\modules\nomenclature\controllers;

use Yii;
use warehouse\modules\nomenclature\forms\ProductComponentForm;
use common\components\controllers\CrudController;
use common\models\productComponent\ProductComponentSearch;

class ProductComponentController extends CrudController
{
    protected function _getSearchClassName()
    {
        return ProductComponentSearch::className();
    }

    protected function _getModelById($id)
    {
        return ProductComponentForm::findById($id);
    }

    protected function _getFormClassName()
    {
        return ProductComponentForm::className();
    }
}