<?php

namespace App\Enums\Project;

use TCore\Base\Traits\EnumTrait;

enum ProjectRequirementStatus: int
{
    use EnumTrait;

    case Todo = 10;
    case Doing = 20;
    case Done = 30;
    case Finish = 40;
    case Paused = 50;
    case Cancel = 60;
    
    public function badge() 
    {
        return match ($this) {
            self::Todo => 'bg-azure text-azure-fg',
            self::Doing => 'bg-blue text-blue-fg',
            self::Done => 'bg-green text-green-fg',
            self::Finish => 'bg-orange text-green-fg',
            self::Paused => 'bg-orange text-orange-fg',
            self::Cancel => 'bg-red text-red-fg',
        };
    }
}
