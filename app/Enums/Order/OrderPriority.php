<?php

namespace App\Enums\Order;

use TCore\Base\Traits\EnumTrait;

enum OrderPriority: int
{
    use EnumTrait;

    case Default = 10;

    case Low = 20;

    case Medium = 30;

    case High = 40;

    public function badge()
    {
        return match($this) {
            OrderPriority::Default => 'bg-info text-info-fg',
            OrderPriority::Low => 'bg-info text-info-fg',
            OrderPriority::Medium => 'bg-orange text-orange-fg',
            OrderPriority::High => 'bg-red text-red-fg'
        };
    }
}
