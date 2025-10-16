<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use TCore\Base\Models\BaseModel;

class RangePrice extends BaseModel
{
    use HasFactory;

    protected $table = 'range_prices';

    protected $fillable = [
        'admin_id',
        'name',
        'min_price',
        'max_price',
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'range_price_id', 'id');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'range_price_id', 'id');
    }
}
