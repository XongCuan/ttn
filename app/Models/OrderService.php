<?php

namespace App\Models;

use App\Enums\Order\ServiceStatus;
use App\Enums\Order\ServiceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use TCore\Base\Models\BaseModel;

class OrderService extends BaseModel
{
    use HasFactory;

    protected $table = 'order_services';

    protected $fillable = [
        'order_id',
        'type',
        'amount',
        'number_month',
        'active',
        'status',
        'day_begin',
        'day_end',
        'desc'
    ];

    protected $casts = [
        'active' => 'boolean',
        'type' => ServiceType::class,
        'status' => ServiceStatus::class,
        'amount' => 'double'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id')->withDefault();
    }

    public function completed()
    {
        return $this->status == ServiceStatus::Completed;
    }
}
