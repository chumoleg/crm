<?php

namespace backend\modules\management\modules\process\controllers;

use common\components\controllers\CrudController;
use common\models\reason\ReasonSearch;
use backend\modules\management\modules\process\forms\ReasonForm;

class ReasonController extends CrudController
{
    protected function _getSearchClassName()
    {
        return ReasonSearch::className();
    }

    protected function _getModelById($id)
    {
        return ReasonForm::findById($id);
    }

    protected function _getFormClassName()
    {
        return ReasonForm::className();
    }
}
