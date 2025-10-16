<?php

namespace TCore\Base\Enums\LeaveRequest;

use TCore\Base\Traits\EnumTrait;

enum HalfDayType: string
{
    use EnumTrait;

    case Morning = 'morning';

    case Afternoon = 'afternoon';
    
}
