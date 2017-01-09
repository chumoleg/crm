<?php

namespace common\components\base;

use Yii;

class User extends \yii\web\User
{
    public function init()
    {
        parent::init();
//        $this->loginUrl = 'http://' . Yii::$app->params['baseUrl'] . '/site/login';
    }

    public function getWorkPlace()
    {
        return Yii::$app->session->get('workPlace');
    }

    public function getModel()
    {
        return \common\models\user\User::find()->andWhere(['id' => $this->id])->one();
    }
}