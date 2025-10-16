<?php

namespace App\Enums\Customer;

use TCore\Base\Traits\EnumTrait;

enum CustomerReturnStatus: int
{
    use EnumTrait;

    case Consulting = 10;   //dang tu van

    case Deposited = 20;    //da coc

    case Canceled = 30;    //huy

    case Completed = 40;        //hoan thanh


    public function badge(){
        return match($this) {
            CustomerReturnStatus::Consulting => 'bg-azure-lt',
            CustomerReturnStatus::Deposited => 'bg-orange-lt',
            CustomerReturnStatus::Canceled => 'bg-red-lt',
            CustomerReturnStatus::Completed => 'bg-green-lt',
        };
    }

    public static function asSelectArrayAvailable()
    {
        $data = self::asSelectArray();
        
        unset($data[self::Completed->value]);

        return $data;
    }
}
