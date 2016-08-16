<?php

namespace common\components\helpers;

use Yii;
use yii\helpers\Html;

class FormButton
{
    public static function getButtons($cancelUrl = ['index'])
    {
        $submit = Html::submitButton('Сохранить',
            ['class' => 'btn btn-primary', 'name' => 'submit-button']);

        $cancel = Html::a('Отмена', ArrayHelper::merge($cancelUrl, Yii::$app->request->get()),
            ['class' => 'btn btn-default']);

        return $submit . '&nbsp;' . $cancel;
    }
}