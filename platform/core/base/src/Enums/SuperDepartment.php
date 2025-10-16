<?php

namespace TCore\Base\Enums;

use TCore\Base\Traits\EnumTrait;

enum SuperDepartment: int
{
    use EnumTrait;

    case None = 0;

    case Operation = 10;

    case BussinessDevelopment = 20;
    
    case ProductDevelopment = 30;

    case Other = 200;

    public static function asSelectArrayAvailable()
    {
        $data = self::asSelectArray();
        
        unset($data[self::Operation->value]);

        return $data;
    }
}
