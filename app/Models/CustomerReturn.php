<?php

namespace App\Models;

use App\Enums\Customer\CustomerReturnStatus;
use TCore\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerReturn extends BaseModel
{
    use HasFactory;

    protected $table = 'customer_returns';

    protected $fillable = [
        'admin_id',
        'customer_id',
        'status',
        'note'
    ];

    protected function casts()
    {
        return [
            'status' => CustomerReturnStatus::class,
        ];
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'admin_id')->withDefault(['fullname' => null]);
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id', 'id')->withDefault();
    }
}