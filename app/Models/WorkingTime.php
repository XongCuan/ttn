<?php

namespace App\Models;

use Carbon\Carbon;
use TCore\Base\Enums\Department;
use TCore\Base\Enums\WorkingTimeStatus;
use TCore\Base\Models\BaseModel;

class WorkingTime extends BaseModel
{
    //
    protected $table = 'working_times';

    protected $fillable = [
        'admin_id',
        'date',
        'check_in',
        'check_out',
        'status',
        'note'
    ];

    protected $appends = ['total_working_hours', 'is_insufficient_hours'];

    protected function casts()
    {
        return [
            'date' => 'date',
            'check_in' => 'datetime:H:i:s',
            'check_out' => 'datetime:H:i:s',
            'status' => WorkingTimeStatus::class
        ];
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function scopeToday($query)
    {
        $query->whereDate('date', now());
    }

    public function calculateStatus()
    {
        $settings = app()->make('App\Models\Setting');
        if ($this->check_in) {

            $startWorkingTime = $settings->getValue('start_working_time');
            $almostOnTimeWorkingTime = $settings->getValue('almost_ontime_working_time');

            $checkInTime = Carbon::createFromFormat('H:i', $this->check_in->format('H:i'));
            $startTime = Carbon::createFromFormat('H:i', $startWorkingTime);
            $almostOnTime = Carbon::createFromFormat('H:i', $almostOnTimeWorkingTime);

            if ($checkInTime->lte($startTime)) {
                return WorkingTimeStatus::OnTime->value;
            }

            if ($checkInTime->lte($almostOnTime)) {
                return WorkingTimeStatus::AlmostOnTime->value;
            }

            return WorkingTimeStatus::Late->value;
        }
    }

    public function getTotalWorkingHoursAttribute()
    {
        if ($this->check_in && $this->check_out) {
            $totalHours = $this->check_in->diffInHours($this->check_out);
            return max(0, $totalHours - 1.5);
        }
        return 0;
    }

    public function getIsInsufficientHoursAttribute()
    {
        return $this->total_working_hours < 8 ? 1 : 0;
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($workingTime) {
            $workingTime->status = $workingTime->calculateStatus();
        });
    }

    public function scopeCurrentAuth($q)
    {
        $auth = get_auth_admin();

        if($auth->isSuperadmin())
        {

        }elseif($auth->isManagerSales()) {

            $q->whereHas('admin', fn($query) => $query->whereRelation('team', 'department', Department::Sales)->where('admin_id', '!=', $auth->id));
        }elseif($auth->isManagerMKT()) {

            $q->whereHas('admin', fn($query) => $query->whereRelation('team', 'department', Department::Marketing)->where('admin_id', '!=', $auth->id));
        }elseif($auth->isManagerOutSource()) {

            $q->whereHas('admin', fn($query) => $query->whereRelation('team', 'department', Department::Outsource)->where('admin_id', '!=', $auth->id));
        }else {
            $q->where('admin_id', $auth->id);
        }
    }
}
