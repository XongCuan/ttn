<?php

namespace TCore\WorkingTime\Enums;

use TCore\Base\Traits\EnumTrait;

enum WorkingTimeTicketStatus: int
{
    use EnumTrait;
    
    case Pending = 10;

    case Approved = 20;
    
    case Refuse = 30;

    public function badge()
    {
        return match($this) {
            self::Pending => 'bg-yellow-lt text-yellow-lt-fg',
            self::Approved => 'bg-green-lt text-green-lt-fg',
            self::Refuse => 'bg-red-lt text-red-lt-fg',
        };
    }
}
