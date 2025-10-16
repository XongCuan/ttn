<?php

namespace App\Enums;

use TCore\Base\Traits\EnumTrait;

enum Area: int
{
    use EnumTrait;

    case North = 10; //bac

    case Central = 20; //trung
    
    case South = 30; //nam
}
