<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use TCore\Base\Models\BaseModel;

class Receipt extends BaseModel
{
    protected $table = 'receipts';

    protected $fillable = [
        'type_id', 'receipt_date', 'amount', 'attachments', 'desc'
    ];

    protected function casts()
    {
        return [
            'attachments' => AsArrayObject::class
        ];
    }

    public function type()
    {
        return $this->belongsTo(ReceiptType::class, 'type_id')->withDefault();
    }
}
