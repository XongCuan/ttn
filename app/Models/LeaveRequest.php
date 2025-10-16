<?php

namespace App\Models;

use Carbon\Carbon;
use TCore\Base\Enums\LeaveRequest\{LeaveRequestStatus, HalfDayType, LeaveRequestType};
use TCore\Base\Models\BaseModel;

class LeaveRequest extends BaseModel
{
    //
    protected $table = 'leave_requests';

    protected $fillable = [
        'admin_id',
        'title',
        'type',
        'status',
        'start_date',
        'end_date',
        'file',
        'is_half_day',
        'half_day_type',
        'reason',
        'approved_at'
    ];

    protected function casts()
    {
        return [
            'type' => LeaveRequestType::class,
            'check_in' => 'datetime:H:i:s',
            'check_out' => 'datetime:H:i:s',
            'status' => LeaveRequestStatus::class,
            'half_day_type' => HalfDayType::class,
        ];
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function isPending()
    {
        return $this->status == LeaveRequestStatus::Pending;
    }

    public function scopeApproved($q)
    {
        $q->where('status', LeaveRequestStatus::Approved);
    }

}
