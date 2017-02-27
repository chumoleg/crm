<?php

namespace common\components\helpers;

use Yii;

class DepartmentHelper
{
    const CRM = 1;
    const WAREHOUSE = 2;
    const DELIVERY = 3;
    const PURCHASE = 4;

    public static $departmentList
        = [
            self::CRM       => 'CRM',
            self::WAREHOUSE => 'Склад',
//            self::DELIVERY    => 'Отправка',
//            self::PURCHASE    => 'Отдел выкупа',
        ];

    public static function getDepartmentByApplication()
    {
        $array = [
            'app-call-center' => self::CRM,
            'app-warehouse'   => self::WAREHOUSE,
        ];

        return ArrayHelper::getValue($array, Yii::$app->id);
    }
}