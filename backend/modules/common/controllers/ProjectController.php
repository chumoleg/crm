<?php

namespace backend\modules\common\controllers;

use common\components\controllers\CrudController;
use common\models\project\ProjectSearch;
use backend\modules\common\forms\ProjectForm;

class ProjectController extends CrudController
{
    protected function _getSearchClassName()
    {
        return ProjectSearch::className();
    }

    protected function _getModelById($id)
    {
        return ProjectForm::findById($id);
    }

    protected function _getFormClassName()
    {
        return ProjectForm::className();
    }
}
