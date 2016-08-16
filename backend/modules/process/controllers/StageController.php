<?php

namespace backend\modules\management\modules\process\controllers;

use common\components\controllers\CrudController;
use common\models\stage\StageSearch;
use backend\modules\management\modules\process\forms\StageForm;

class StageController extends CrudController
{
    protected function _getSearchClassName()
    {
        return StageSearch::className();
    }

    protected function _getModelById($id)
    {
        return StageForm::findById($id);
    }

    protected function _getFormClassName()
    {
        return StageForm::className();
    }
}
