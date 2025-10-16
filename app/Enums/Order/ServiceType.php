<?php

namespace App\Enums\Order;

use TCore\Base\Traits\EnumTrait;

enum ServiceType: int
{
    use EnumTrait;

    case Website = 10;

    case Hosting = 20;

    case Domain = 30;

    case Seo = 40;
}
