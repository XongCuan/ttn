<?php

namespace TCore\Base\Enums;

use TCore\Base\Traits\EnumTrait;

enum Department: int
{
    use EnumTrait;

    case Marketing = 10;

    case Sales = 20;

    case Internal = 30;

    case Outsource = 40;

    case Webadmin = 50;

    case Accounting = 60;

    public function super()
    {
        return match($this) {
            Department::Marketing, Department::Sales => SuperDepartment::BussinessDevelopment,
            
            Department::Internal, Department::Outsource, Department::Webadmin => SuperDepartment::ProductDevelopment,
            
            default => SuperDepartment::Other
        };
    }
}
