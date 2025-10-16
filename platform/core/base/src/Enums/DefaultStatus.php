<?php

namespace TCore\Base\Enums;

use TCore\Base\Traits\EnumTrait;

enum DefaultStatus: int
{
    use EnumTrait;

    case Published = 10;

    case Draft = 20;

    public function badge(){
        return match($this) {
            static::Published => 'bg-green',
            static::Draft => '',
        };
    }
}
