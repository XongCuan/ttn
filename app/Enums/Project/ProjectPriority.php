<?php

namespace App\Enums\Project;

use TCore\Base\Traits\EnumTrait;

enum ProjectPriority: int
{
    use EnumTrait;

    case Default = 10;

    case Low = 20;

    case Medium = 30;

    case High = 40;

    public function badge()
    {
        return match($this) {
            ProjectPriority::Default => 'bg-info text-info-fg',
            ProjectPriority::Low => 'bg-info text-info-fg',
            ProjectPriority::Medium => 'bg-orange text-orange-fg',
            ProjectPriority::High => 'bg-red text-red-fg'
        };
    }
}
