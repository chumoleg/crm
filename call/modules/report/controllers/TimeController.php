<?php

namespace call\modules\report\controllers;

use common\components\controllers\BaseController;
use call\modules\report\components\TimeReport;

class TimeController extends BaseController
{
    public function actionIndex()
    {
        $data = (new TimeReport())->getData();
        return $this->render('index', ['data' => $data]);
    }
}
