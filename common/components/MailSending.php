<?php

namespace common\components;

class MailSending
{
    const CLIENT_COUNTERS = 1;

    public static $typeList
        = [
            self::CLIENT_COUNTERS => 'Какая-то рассылка',
        ];
}
