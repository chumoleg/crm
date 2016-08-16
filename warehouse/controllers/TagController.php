<?php

namespace warehouse\controllers;

use common\components\controllers\CrudController;
use common\models\tag\TagSearch;
use warehouse\forms\TagForm;

class TagController extends CrudController
{
    protected function _getSearchClassName()
    {
        return TagSearch::className();
    }

    protected function _getModelById($id)
    {
        return TagForm::findById($id);
    }

    protected function _getFormClassName()
    {
        return TagForm::className();
    }
}
