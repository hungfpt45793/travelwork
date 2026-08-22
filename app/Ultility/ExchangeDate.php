<?php

namespace App\Ultility;

use App\Category;

class ExchangeDate
{
    // lay ve tong so phut cua phong thi lam so phut cua de thi
    public static function getMinute($time)
    {
        $array_time = explode(':',$time);
        $minutes = intval($array_time[1]);
        $hours = intval($array_time[0]);
        $result = (int)($minutes) + ($hours*60);
        return $result;
    }
}
