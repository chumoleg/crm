<?php

namespace backend\modules\management\modules\common\controllers;

use common\components\controllers\CrudController;
use common\models\source\SourceSearch;
use backend\modules\management\modules\common\forms\SourceForm;

class SourceController extends CrudController
{
    protected function _getSearchClassName()
    {
        return SourceSearch::className();
    }

    protected function _getModelById($id)
    {
        return SourceForm::findById($id);
    }

    protected function _getFormClassName()
    {
        return SourceForm::className();
    }
}
