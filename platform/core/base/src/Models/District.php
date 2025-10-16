<?php

namespace TCore\Base\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends BaseModel
{
    use HasFactory;

    protected $table = "districts";

    protected $fillable = [
        'province_code',
        'code',
        'name',
        'division_type',
        'codename',
    ];

    public function wards()
    {
        return $this->hasMany(Ward::class, 'district_code', 'code');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }
}
