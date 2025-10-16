<?php

namespace App\Enums\Project;

use TCore\Base\Traits\EnumTrait;

enum ProjectStatus: int
{
    use EnumTrait;

    case Todo = 10;
    case Doing = 20;
    case Demo = 25;
    case Done = 30;
    case Paused = 40;
    case Cancel = 50;
    public function badge() 
    {
        return match ($this) {
            ProjectStatus::Todo => 'bg-azure text-azure-fg',
            ProjectStatus::Doing => 'bg-blue text-blue-fg',
            ProjectStatus::Demo => 'bg-indigo text-indigo-fg',
            ProjectStatus::Done => 'bg-green text-green-fg',
            ProjectStatus::Paused => 'bg-orange text-orange-fg',
            ProjectStatus::Cancel => 'bg-red text-red-fg',
        };
    }
}
