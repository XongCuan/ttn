<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCore\Base\Enums\Department;

class AdminDepartment extends Model
{
    //
    protected $table = 'admin_departments';

    protected $fillable = [
        'admin_id', 'department'
    ];

    protected function casts()
    {
        return [
            'department' => Department::class
        ];
    }
}
