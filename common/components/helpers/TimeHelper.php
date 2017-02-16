<?php

namespace common\components\helpers;

class TimeHelper
{
    const TIME_UNIT_HOUR = 1;
    const TIME_UNIT_MINUTE = 2;
    const TIME_UNIT_DAY = 3;

    public static $unitList
        = [
            self::TIME_UNIT_HOUR   => 'ч',
            self::TIME_UNIT_MINUTE => 'мин',
            self::TIME_UNIT_DAY    => 'сут',
        ];

    /**
     * @param $time
     * @param $unit
     *
     * @return mixed
     */
    public static function getInSecond($time, $unit)
    {
        $values = [
            self::TIME_UNIT_HOUR   => 60 * 60,
            self::TIME_UNIT_MINUTE => 60,
            self::TIME_UNIT_DAY    => 60 * 60 * 24,
        ];

        $value = ArrayHelper::getValue($values, $unit);

        return !empty($value) ? $time * $value : $time;
    }

    /**
     * @param int  $seconds
     * @param bool $withSeconds
     *
     * @return string
     */
    public static function secondsToString($seconds, $withSeconds = true)
    {
        $times = [];

        // считать нули в значениях
        $countZero = false;

        // секунд в минуте|часе|сутках
        $periods = [60, 3600, 86400];

        for ($i = 2; $i >= 0; $i--) {
            $period = floor($seconds / $periods[$i]);
            if (($period > 0) || ($period == 0 && $countZero)) {
                $times[$i + 1] = $period;
                $seconds -= $period * $periods[$i];
                $countZero = true;
            }
        }

        if ($seconds != 0) {
            $times[0] = $seconds;
        }

        $text = '';
        $text .= !empty($times[3]) ? $times[3] . ' сут ' : '';
        $text .= !empty($times[2]) ? $times[2] . ' ч ' : '';
        $text .= !empty($times[1]) ? $times[1] . ' мин ' : '';

        if ($withSeconds) {
            $text .= isset($times[0]) ? $times[0] . ' сек ' : '';
        }

        return $text;
    }

    public static function getTimesArray()
    {
        $data = [];
        for ($i = 0; $i < 24; $i++) {
            $time = $i . ':00';
            $data[$time] = $time;
        }

        return $data;
    }
}