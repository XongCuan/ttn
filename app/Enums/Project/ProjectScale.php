<?php

namespace App\Enums\Project;

use TCore\Base\Traits\EnumTrait;

enum ProjectScale: int
{
    use EnumTrait;

    case Small = 10;
    case Medium = 20;
    case Large = 30;
    case Mega = 40;
    
    public function badge() 
    {
        return match ($this) {
            self::Small => 'bg-azure text-azure-fg',
            self::Medium => 'bg-blue text-blue-fg',
            self::Large => 'bg-indigo text-indigo-fg',
            self::Mega => 'bg-green text-green-fg',
        };
    }
}
