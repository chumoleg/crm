<?php

namespace common\components;

use Yii;

class AccessControl extends \yii\filters\AccessControl
{
    protected function denyAccess($user)
    {
        if ($user->getIsGuest()) {
            $user->loginRequired();
        } else {
            Yii::$app->getResponse()->redirect(Yii::$app->getHomeUrl())->send();
            Yii::$app->end();
        }
    }
}