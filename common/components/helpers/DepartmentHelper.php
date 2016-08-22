<?php

namespace common\components\helpers;

use Yii;

class DepartmentHelper
{
    const CALL_CENTER = 1;
    const WAREHOUSE = 2;
    const DELIVERY = 3;
    const PURCHASE = 4;

    public static $departmentList
        = [
            self::CALL_CENTER => 'Call-центр',
            self::WAREHOUSE   => 'Склад',
//            self::DELIVERY    => 'Отправка',
//            self::PURCHASE    => 'Отдел выкупа',
        ];

    public static function getDepartmentByApplication()
    {
        $array = [
            'app-call-center' => self::CALL_CENTER,
            'app-warehouse'   => self::WAREHOUSE
        ];

        return ArrayHelper::getValue($array, Yii::$app->id);
    }
}