<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveHistory extends Model
{
    protected $table = 'leave_histories';

    protected $fillable = [
        'admin_id',
        'month',
        'year',
        'days_added'
    ];
}
