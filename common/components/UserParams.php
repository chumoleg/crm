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
        if (Yii::$app->user->isGuest || Yii::$app->user->can(Role::ADMIN)) {
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
            Role::ADMIN             => Yii::$app->params['baseUrl'],
            Role::OPERATOR          => Yii::$app->params['callUrl'],
            Role::WAREHOUSE_MANAGER => Yii::$app->params['warehouseUrl'],
        ];

        $baseUrl = ArrayHelper::getValue($homeUrls, Yii::$app->user->identity->role);
        if (empty($baseUrl)) {
            return 'http://' . Yii::$app->params['baseUrl'];
        }

        return 'http://' . $baseUrl;
    }
}