<?php

namespace TCore\Base\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ward extends BaseModel
{
    use HasFactory;

    protected $table = "wards";

    protected $fillable = [
        'district_code',
        'code',
        'name',
        'division_type',
        'codename',
    ];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_code', 'code');
    }
}
