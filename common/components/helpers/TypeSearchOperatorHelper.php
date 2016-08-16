<?php

namespace common\components\helpers;

class TypeSearchOperatorHelper
{
    const BY_IF_WORKED = 1;
    const BY_IN_ORDER = 2;
    const BY_FREE = 3;

    public static $typeList
        = [
            self::BY_IF_WORKED => 'Сначала тем, кто уже работал',
            self::BY_IN_ORDER  => 'Равномерно (по порядку)',
//            self::BY_FREE     => 'Первому освободившемуся',
        ];
}