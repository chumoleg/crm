<?php

namespace common\components;

class Status
{
    const STATUS_ARCHIVE = 2;
    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 0;

    /**
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_NOT_ACTIVE => 'Заблокирован',
            self::STATUS_ACTIVE     => 'Активный',
        ];
    }

    /**
     * @return array
     */
    public static function getStatusListYesNo()
    {
        return [
            self::STATUS_NOT_ACTIVE => 'Нет',
            self::STATUS_ACTIVE     => 'Да',
        ];
    }
}