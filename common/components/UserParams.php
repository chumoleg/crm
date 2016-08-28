<?php

namespace common\components;

use Yii;
use yii\base\BootstrapInterface;
use yii\helpers\ArrayHelper;

class UserParams implements BootstrapInterface
{
    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        if (Yii::$app->getUser()->getIsGuest() || Yii::$app->getUser()->can(Role::ADMIN)) {
            return;
        }

        $baseUrl = self::getHomeUrl();
        if (!empty($baseUrl)) {
            Yii::$app->setHomeUrl($baseUrl);
        }
    }

    public static function getHomeUrl()
    {
        $homeUrls = [
            Role::ADMIN    => Yii::$app->params['baseUrl'],
            Role::OPERATOR => Yii::$app->params['callUrl']
        ];

        $baseUrl = ArrayHelper::getValue($homeUrls, Yii::$app->getUser()->getIdentity()->role);
        if (empty($baseUrl)) {
            return 'http://' . Yii::$app->params['baseUrl'];
        }

        return 'http://' . $baseUrl;
    }
}