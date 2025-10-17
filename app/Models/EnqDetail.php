<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnqDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'enq_id',
        'code',
        'description_sale',
        'quantity',
        'unit',
        'unit_price',
        'total_price',
        'delivery_time',
        'note',
        'sort_order',
    ];

    public function enq()
    {
        return $this->belongsTo(Enq::class);
    }
}
