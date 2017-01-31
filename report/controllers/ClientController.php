<?php

namespace report\controllers;

use common\components\controllers\BaseController;
use report\components\ClientReport;

class ClientController extends BaseController
{
    public function actionIndex()
    {
        $data = (new ClientReport())->getData();
        return $this->render('index', ['data' => $data]);
    }
}
