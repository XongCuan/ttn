<?php

namespace TCore\Base\Enums\LeaveRequest;

use TCore\Base\Traits\EnumTrait;

enum LeaveRequestStatus: int
{
    use EnumTrait;

    case Approved = 20;
    case Pending = 10;
    case Refused = 30;

    public function badge(){
        return match($this) {
            LeaveRequestStatus::Approved => 'bg-green text-green-fg',
            LeaveRequestStatus::Pending => 'bg-secondary text-secondary-fg',
            LeaveRequestStatus::Refused => 'bg-red text-red-fg',
        };
    }
}
