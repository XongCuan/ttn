<?php

namespace App\Enums\Customer;

use TCore\Base\Traits\EnumTrait;

enum CustomerType: int
{
    use EnumTrait;

    case New = 10;

    case Old = 20;
}
