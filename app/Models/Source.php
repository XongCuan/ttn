<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use TCore\Base\Models\BaseModel;

class Source extends BaseModel
{
    use HasFactory;

    protected $table = 'sources';

    protected $fillable = [
        'admin_id',
        'is_default',
        'name',
        'desc'
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'source_id', 'id');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'source_id', 'id');
    }
}
