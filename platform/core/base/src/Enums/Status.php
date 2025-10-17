<?php

namespace TCore\Base\Enums;

use TCore\Base\Traits\EnumTrait;

enum Status: string
{
    use EnumTrait;

    case Pending = 'Pending';
    case TakingPrice= 'Đang Lấy Giá';
    case QuotedPrice = 'Đã Báo Giá';
    case HavePo = 'Đã Có PO';
    

}