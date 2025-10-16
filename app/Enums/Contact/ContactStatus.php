<?php

namespace App\Enums\Contact;

use TCore\Base\Traits\EnumTrait;

enum ContactStatus: int
{
    use EnumTrait;

    case NotConsulted = 5;   //chua tu van
    case Consulting = 10;   //dang tu van
    case Deposited = 20;    //da coc
    case Quoted = 30;      //gui bao gia
    case Canceled = 40;    //huy
    case Fake = 50;        //ao
    case Completed = 60;        //hoan thanh

    public function badge(){
        return match($this) {
            ContactStatus::NotConsulted => 'bg-azure-lt',
            ContactStatus::Consulting => 'bg-azure-lt',
            ContactStatus::Deposited => 'bg-orange-lt',
            ContactStatus::Quoted => 'bg-cyan-lt',
            ContactStatus::Canceled => 'bg-red-lt',
            ContactStatus::Fake => 'bg-secondary-lt',
            ContactStatus::Completed => 'bg-green-lt',
        };
    }

    public static function asSelectArrayAvailable()
    {
        $data = self::asSelectArray();
        
        unset($data[self::Completed->value]);

        return $data;
    }
}
