<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use TCore\Base\Models\BaseModel;

class TypeOvertime extends BaseModel
{
    use HasFactory;

    protected $table = 'type_overtimes';

    protected $fillable = [
        'name',
        'value'
    ];
}
