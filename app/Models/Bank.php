<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use TCore\Base\Models\BaseModel;

class Bank extends BaseModel
{
    use HasFactory;

    protected $table = 'banks';

    protected $fillable = [
        'name',
        'code',
        'bin',
        'logo'
    ];

    public function displayName()
    {
        return sprintf('%s - %s', $this->name, $this->code);
    }
}
