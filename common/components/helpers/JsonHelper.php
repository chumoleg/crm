<?php

namespace common\components\helpers;

use Yii;
use yii\helpers\Json;

class JsonHelper
{
    /**
     * @param $message
     *
     * @return array
     */
    public static function answerError($message)
    {
        echo Json::encode([
            'status'  => 'error',
            'message' => $message
        ]);
        Yii::$app->end();
    }

    /**
     * @param string|array $response
     *
     * @return array
     */
    public static function answerSuccess($response = null)
    {
        echo Json::encode([
            'status'   => 'success',
            'response' => $response
        ]);
        Yii::$app->end();
    }
}