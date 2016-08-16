<?php

namespace common\components\nomenclature;

use common\components\helpers\ArrayHelper;

class TypePayment
{
    const POST_PAYMENT = 1;
    const PRE_PAYMENT = 2;

    public static $list
        = [
            self::POST_PAYMENT => 'Постоплата',
            self::PRE_PAYMENT  => 'Предоплата',
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