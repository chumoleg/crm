<?php

namespace frontend\modules\report\controllers;

use common\components\controllers\BaseController;

class IndexController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
