<?php

namespace common\components\helpers;

use Yii;

class DatePicker
{
    /**
     * @param        $searchModel
     * @param string $attribute
     *
     * @return string
     * @throws \Exception
     */
    public static function getInput($searchModel, $attribute = 'date_create')
    {
        return \yii\jui\DatePicker::widget([
            'model'     => $searchModel,
            'attribute' => $attribute,
        ]);
    }
}