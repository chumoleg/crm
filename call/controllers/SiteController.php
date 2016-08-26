<?php
namespace call\controllers;

use Yii;
use common\components\controllers\BaseController;

class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
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
        if (Yii::$app->user->isGuest) {
            return $this->redirect(Yii::$app->user->loginUrl);
        }

        return $this->render('index');
    }

    public function actionLogin()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(Yii::$app->user->loginUrl);
        } else {
            return $this->goHome();
        }
    }
}
