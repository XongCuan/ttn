<?php

namespace TCore\Base\Enums\LeaveRequest;

use TCore\Base\Traits\EnumTrait;

enum LeaveRequestType: int
{
    use EnumTrait;

    case UnpaidLeave = 10; //khong luong
    case AnnualLeave = 20; //phep nam
    case SpecialLeave = 30; // truong hop dac biet 
    case Remote = 40;

    public function badge(){
        return match($this) {
            LeaveRequestType::AnnualLeave => 'bg-green text-green-fg',
            LeaveRequestType::UnpaidLeave => 'bg-secondary text-secondary-fg',
            LeaveRequestType::SpecialLeave => 'bg-red text-red-fg',
            LeaveRequestType::Remote => 'bg-red text-blue-fg',
        };
    }
}
