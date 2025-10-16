<?php

namespace App\Enums\Setting;

use TCore\Base\Traits\EnumTrait;

enum SettingGroup: int
{
    use EnumTrait;

    case General = 10;

    case WorkingTime = 20;
    
    case KpiSales = 30;

    case KpiMkt = 40;
}
