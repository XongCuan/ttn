<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use TCore\Base\Models\BaseModel;

class Sector extends BaseModel
{
    use HasFactory;

    protected $table = 'sectors';

    protected $fillable = [
        'admin_id',
        'name',
        'description',
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'sector_id', 'id');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'sector_id', 'id');
    }
}
