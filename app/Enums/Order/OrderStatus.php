<?php

namespace App\Enums\Order;

use TCore\Base\Traits\EnumTrait;

enum OrderStatus: int
{
    use EnumTrait;

    case Unpaid = 10;

    case Paymented = 20;

    case Deposited = 30;

    case Cancel = 40;

    case UnderAcceptance = 50;

    case DelayAcceptance = 60;

    case Accepted = 70;

    case Completed = 80;

    public function badge()
    {
        return match($this) {
            OrderStatus::Unpaid => 'bg-secondary text-secondary-fg',
            OrderStatus::Paymented => 'bg-orange text-orange-fg',
            OrderStatus::Deposited => 'bg-blue text-blue-fg',
            OrderStatus::Cancel => 'bg-red text-red-fg',
            OrderStatus::UnderAcceptance => 'bg-red text-blue-fg',
            OrderStatus::DelayAcceptance => 'bg-red text-red-fg',
            OrderStatus::Accepted => 'bg-green text-green-fg',
            OrderStatus::Completed => 'bg-green text-green-fg',
        };
    }
}
