<?php

namespace TCore\Sales\Http\Controllers;

use App\Enums\Setting\SettingGroup;
use TCore\Setting\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function kpi()
    {
        return $this->index(SettingGroup::KpiSales->value, route('sales.setting.update'));
    }
}