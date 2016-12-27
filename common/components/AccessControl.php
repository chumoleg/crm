<?php

namespace common\components;

use Yii;
use yii\base\BootstrapInterface;
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
        $redirect = Yii::$app->getUser()->loginUrl;
        if (Yii::$app->user->isGuest) {
            Yii::$app->getResponse()->redirect($redirect)->send();
            Yii::$app->end();

        } else {
            $userRole = Yii::$app->user->identity->role;
            if ($userRole != Role::ADMIN && !in_array($userRole, $this->roles)) {
                Yii::$app->getResponse()->redirect(Yii::$app->getHomeUrl())->send();
                Yii::$app->end();
            }
        }
    }
}