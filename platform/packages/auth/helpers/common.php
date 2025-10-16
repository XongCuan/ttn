<?php

use App\Models\Admin;

if (! function_exists('get_auth_admin')) {
    function get_auth_admin(): Admin
    {
        return auth('admin')->user();
    }
}