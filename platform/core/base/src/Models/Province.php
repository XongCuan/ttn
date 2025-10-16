<?php

namespace TCore\Base\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends BaseModel
{
    use HasFactory;

    protected $table = "provinces";

    protected $fillable = [
        'code',
        'name',
        'division_type',
        'codename',
        'phone_code',
    ];

    public function districts()
    {
        return $this->hasMany(District::class, 'province_code', 'code');
    }
}
