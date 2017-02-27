<?php
namespace frontend\controllers;

use Yii;
use common\components\controllers\BaseController;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $this->showTitleLegend = false;

        return $this->render('index');
    }

    public function actionClearCache()
    {
        Yii::$app->cache->flush();

        return $this->redirect(['index']);
    }
}
