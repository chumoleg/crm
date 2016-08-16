<?php

namespace backend\modules\management\modules\common\controllers;

use common\components\controllers\CrudController;
use common\models\user\UserSearch;
use backend\modules\management\modules\common\forms\UserForm;

class UserController extends CrudController
{
    public $useScenarios = true;

    protected function _getSearchClassName()
    {
        return UserSearch::className();
    }

    protected function _getModelById($id)
    {
        return UserForm::findById($id);
    }

    protected function _getFormClassName()
    {
        return new UserForm();
    }
}
