<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use TCore\Base\Models\BaseModel;

class OrderArise extends BaseModel
{
    use HasFactory;

    protected $table = 'order_arises';

    protected $fillable = [
        'order_id',
        'name',
        'amount',
        'desc',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id')->withDefault();
    }
}
