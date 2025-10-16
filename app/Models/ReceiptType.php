<?php

namespace App\Models;

use TCore\Base\Models\BaseModel;

class ReceiptType extends BaseModel
{
    protected $table = 'receipt_types';

    protected $fillable = [
        'name', 'desc'
    ];
}
