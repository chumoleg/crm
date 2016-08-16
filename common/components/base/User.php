<?php

namespace common\components\base;

use Yii;

class User extends \yii\web\User
{
    public function getWorkPlace()
    {
        return Yii::$app->session->get('workPlace');
    }
}