<?php

use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;

if(!function_exists('get_working_days'))
{
    function get_working_days($startDate, $endDate)
{
    $start = Carbon::parse($startDate);
    $end = Carbon::parse($endDate);

    $period = CarbonPeriod::create($start, $end);

    $count = 0;
    foreach ($period as $date)
    {
        if (!in_array($date->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY]))
        {
            $count++;
        }
    }

    return $count;
}
}