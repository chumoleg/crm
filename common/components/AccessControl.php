<?php

namespace common\components;

use Yii;
use yii\base\BootstrapInterface;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;

class AccessControl implements BootstrapInterface
{
    public $roles = [];

    /**
     * @param \yii\base\Application $app
     *
     * @throws ForbiddenHttpException
     */
    public function bootstrap($app)
    {
        if (Yii::$app->user->isGuest) {
            $url = UserParams::getHomeUrl();
            Yii::$app->getResponse()->redirect($url)->send();
            Yii::$app->end();

        } else {
            $userRole = Yii::$app->user->getRole();
            if ($userRole != Role::ADMIN && !in_array($userRole, $this->roles)) {
                $url = Yii::$app->getHomeUrl();

                Yii::$app->getResponse()->redirect($url)->send();
                Yii::$app->end();
            }
        }
    }
}