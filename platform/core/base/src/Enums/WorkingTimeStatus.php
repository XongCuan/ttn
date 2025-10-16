<?php

namespace TCore\Base\Enums;

use TCore\Base\Traits\EnumTrait;

enum WorkingTimeStatus: int
{
    use EnumTrait;
    
    case OnTime = 10;

    case AlmostOnTime = 15;
    
    case Late = 20;

    public function badge(){
        return match($this) {
            WorkingTimeStatus::OnTime => 'bg-green text-green-fg',
            WorkingTimeStatus::AlmostOnTime => 'bg-yellow text-yellow-fg',
            WorkingTimeStatus::Late => 'bg-red text-red-fg'
        };
    }
}
