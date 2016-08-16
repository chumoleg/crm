<?php

namespace frontend\components;

use Yii;
use yii\base\BootstrapInterface;
use yii\helpers\Url;

class UserParams implements BootstrapInterface
{
    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        if (Yii::$app->user->isGuest) {
            return;
        }

        $baseUrl = Url::to('/order/order/index');
        Yii::$app->setHomeUrl($baseUrl);
        Yii::$app->urlManager->addRules(['/' => $baseUrl], false);
    }
}