<?php

namespace frontend\modules\order\controllers;

use common\components\controllers\CrudController;
use common\models\client\Client;
use common\models\client\ClientSearch;

class ClientController extends CrudController
{
    protected function _getSearchClassName()
    {
        return ClientSearch::className();
    }

    protected function _getModelById($id)
    {
        return Client::findById($id);
    }

    protected function _getFormClassName()
    {
        return new Client();
    }
}
