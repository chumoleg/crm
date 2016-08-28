<?php

namespace report\controllers;

use common\components\controllers\BaseController;

class SiteController extends BaseController
{
    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}
