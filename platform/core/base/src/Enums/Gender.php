<?php

namespace TCore\Base\Enums;

use TCore\Base\Traits\EnumTrait;

enum Gender: string
{
    use EnumTrait;

    case EU = 'EU';
    case TM = 'TM';
    case CN = 'CN';
    

    case Male = 'Male';
    case Female = 'Female';
}