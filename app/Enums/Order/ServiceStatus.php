<?php

namespace App\Enums\Order;

use TCore\Base\Traits\EnumTrait;

enum ServiceStatus: int
{
    use EnumTrait;

    case Inactive = 10;

    case Active = 20;

    case Completed = 30;

    case Valid = 40;

    case Expired = 50;

    public function badge()
    {
        return match($this) {
            ServiceStatus::Inactive => 'bg-secondary text-secondary-fg',
            ServiceStatus::Active => 'bg-green text-green-fg',
            ServiceStatus::Completed => 'bg-green text-green-fg',
            ServiceStatus::Valid => 'bg-green text-green-fg',
            ServiceStatus::Expired => 'bg-red text-red-fg',
            default => ''
        };
    }
}
