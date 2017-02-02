<?php

namespace common\components;

class MailSending
{
    const ORDERS_ON_TODAY = 1;
    const OVERDUE_ON_TODAY = 2;

    public static $typeList
        = [
            self::ORDERS_ON_TODAY  => 'По событиям на сегодня',
            self::OVERDUE_ON_TODAY => 'По просроченным на сегодня',
        ];
}
