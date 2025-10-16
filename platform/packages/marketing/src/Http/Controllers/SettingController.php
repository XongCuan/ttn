<?php

namespace TCore\Marketing\Http\Controllers;

use App\Enums\Setting\SettingGroup;
use TCore\Setting\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function kpi()
    {
        return $this->index(SettingGroup::KpiMkt->value, route('marketing.setting.update'));
    }
}