<?php

use Carbon\Carbon;
use TCore\Base\Enums\DefaultStatus;
use TCore\Base\Supports\Utilities;

if (! function_exists('platform_public')) {
    function platform_public(string $type = 'core', string $module): string
    {
        return "platform/{$type}/{$module}/public";
    }
}

if (! function_exists('platform_resource')) {
    function platform_resource(string $type, string $module): string
    {
        return "platform/{$type}/{$module}/resources";
    }
}

if (! function_exists('platform_path')) {
    function platform_path(string|null $path = null): string
    {
        return base_path('platform' . $path);
    }
}

if (! function_exists('core_path')) {
    function core_path(string|null $path = null): string
    {
        return platform_path('core' . $path);
    }
}

if (! function_exists('modules_path')) {
    function modules_path(string|null $path = null): string
    {
        return platform_path('modules' . $path);
    }
}

if (! function_exists('themes_path')) {
    function themes_path(string|null $path = null): string
    {
        return platform_path('themes' . $path);
    }
}

if (! function_exists('utilities')) {
    function utilities(): Utilities
    {
        return app('utilities');
    }
}

if (! function_exists('enum_default_status')) {
    function enum_default_status($value): DefaultStatus
    {
        return utilities()->enumDefaultStatus($value);
    }
}

if (! function_exists('get_module_name')) {
    function get_module_name(string $path): string
    {
        $path = str_replace(
            [platform_path(), '/', '\\'],
            ['', '_', '_'],
            strstr($path, 'src', true) ?: strstr($path, 'src', true)
        );

        return trim($path, '_');
    }
}

if (! function_exists('check_normal_day')) {
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

if (! function_exists('calculate_distance')) {        
    // Hàm tính khoảng cách giữa hai điểm trên mặt phẳng
    function calculate_distance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371000; // Bán kính trái đất trong mét. kilômét: 6371

        // Đổi độ sang radian
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        // Áp dụng công thức Haversine
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c;

        return $distance; // đơn vị mét

        // $origin = "40.748817,-73.985428"; // Kinh độ và vĩ độ của điểm xuất phát
        // $destination = "34.052235,-118.243683"; // Kinh độ và vĩ độ của điểm đích
        // $key = "AIzaSyAzbVo-3B81-_eIIQHZKPDEm4DLjo0LCFU"; // Thay YOUR_API_KEY bằng API Key của bạn

        // $response = Http::get("https://maps.googleapis.com/maps/api/distancematrix/json", [
        //     'origins' => $origin,
        //     'destinations' => $destination,
        //     'key' => $key,
        // ]);

        // $data = $response->json();
    }
}
