<?php

namespace common\components\nomenclature;

use common\components\helpers\ArrayHelper;

class TypeDelivery
{
    const POST = 1;
    const EXPRESS = 2;

    public static $list
        = [
            self::POST    => 'Почта',
            self::EXPRESS => 'Курьерская служба',
        ];

    /**
     * @param int $type
     *
     * @return null
     */
    public static function getValue($type)
    {
        return ArrayHelper::getValue(self::$list, $type);
    }
}