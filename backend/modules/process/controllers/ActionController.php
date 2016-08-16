<?php

namespace backend\modules\process\controllers;

use common\components\controllers\CrudController;
use common\models\action\ActionSearch;
use backend\modules\process\forms\ActionForm;

class ActionController extends CrudController
{
    protected function _getSearchClassName()
    {
        return ActionSearch::className();
    }

    protected function _getModelById($id)
    {
        return ActionForm::findById($id);
    }

    protected function _getFormClassName()
    {
        return ActionForm::className();
    }
}
