<?php

namespace TCore\WorkingTime\Enums;

use TCore\Base\Traits\EnumTrait;

enum WorkingTimeTicketType: int
{
    use EnumTrait;
    
    case Checkin = 10;

    case Checkout = 20;
    
    case Fullday = 30;

    public function badge()
    {
        return match($this) {
            self::Checkin => 'bg-blue-lt text-blue-lt-fg',
            self::Checkout => 'bg-indigo-lt text-indigo-lt-fg',
            self::Fullday => 'bg-purple-lt text-purple-lt-fg',
        };
    }
}
