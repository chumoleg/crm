<?php

namespace backend\modules\common\controllers;

use backend\modules\common\forms\CompanyForm;
use common\components\controllers\CrudController;
use common\models\company\CompanySearch;

class CompanyController extends CrudController
{
    protected function _getSearchClassName()
    {
        return CompanySearch::className();
    }

    protected function _getModelById($id)
    {
        return CompanyForm::findById($id);
    }

    protected function _getFormClassName()
    {
        return CompanyForm::className();
    }
}
