<?php

namespace TCore\Base\Supports;

use TCore\Base\Enums\DefaultStatus;
use TCore\Base\Traits\ResponseTrait;

class Utilities
{
    use ResponseTrait;

    public static function enumDefaultStatus($value): DefaultStatus
    {
        return DefaultStatus::tryFrom($value);
    }
}