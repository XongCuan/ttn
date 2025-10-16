<?php

namespace TCore\Base\Supports;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class Helper
{
    public static function autoload($directory)
    {
        $helpers = File::glob($directory . '/*.php');

        foreach ($helpers as $helper) {
            File::requireOnce($helper);
        }
    }

    function check_normal_day(Carbon $date = null)
    {
        if ($date == null) {
            $date = Carbon::now();
        }

        if ($date->isWeekday() && $date->dayOfWeek >= 1 && $date->dayOfWeek <= 5) {
            return true;
        } else {
            return false;
        }
    }
}
