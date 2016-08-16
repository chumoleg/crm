<?php

namespace frontend\modules\clientBase\controllers;

use common\components\controllers\CrudController;
use common\models\clientBaseFile\ClientBaseFileData;
use common\models\clientBaseFile\ClientBaseFileDataSearch;

class IndexController extends CrudController
{
    protected function _getSearchClassName()
    {
        return ClientBaseFileDataSearch::className();
    }

    protected function _getModelById($id)
    {
        return ClientBaseFileData::findById($id);
    }

    protected function _getFormClassName()
    {
        return ClientBaseFileData::className();
    }
}
