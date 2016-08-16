<?php

namespace frontend\modules\report\controllers;

use common\components\controllers\BaseController;
use frontend\modules\report\components\TimeReport;

class TimeController extends BaseController
{
    public function actionIndex()
    {
        $data = (new TimeReport())->getData();
        return $this->render('index', ['data' => $data]);
    }
}
