<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use TCore\Base\Models\BaseModel;

class WorkingOvertime extends BaseModel
{
    use HasFactory;

    protected $table = 'working_overtimes';

    protected $fillable = [
        'type_overtime_id',
        'admin_id',
        'hour',
        'date',
        'note'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
    
    public function type()
    {
        return $this->belongsTo(TypeOvertime::class, 'type_overtime_id');
    }
}
