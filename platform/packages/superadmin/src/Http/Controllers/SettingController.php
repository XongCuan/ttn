<?php

namespace TCore\Superadmin\Http\Controllers;

use App\Enums\Setting\SettingGroup;
use TCore\Setting\Http\Controllers\Controller;

class  SettingController extends Controller
{
    public function workingTime()
    {
        return $this->index(SettingGroup::WorkingTime->value, route('superadmin.setting.update'));
    }
}