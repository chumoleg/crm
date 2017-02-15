<?php

namespace report\controllers;

class SiteController extends \common\components\controllers\SiteController
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $this->showTitleLegend = false;

        return $this->render('index');
    }
}
