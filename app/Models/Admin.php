<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use TCore\Acl\Traits\PermissionTrait;
use TCore\Superadmin\Observers\AdminObserver;
use TCore\Base\Enums\Gender;
use TCore\Base\Enums\LeaveRequest\LeaveRequestStatus;
use TCore\Base\Enums\SuperDepartment;
use TCore\Base\Traits\ModelTrait;

#[ObservedBy([AdminObserver::class])]
class Admin extends Authenticatable
{
    use PermissionTrait, ModelTrait, Notifiable;

    protected $table = 'admins';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'team_id',
        'super_department',
        'username',
        'fullname',
        'phone',
        'email',
        'birthday',
        'gender',
        'avatar',
        'status',
        'birthday',
        'is_superadmin',
        'password',
        'latitude',
        'longitude',
        'leave_days',
        'work_remote_date',
        'salary',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_superadmin' => 'boolean',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'gender' => Gender::class,
            'super_department' => SuperDepartment::class
        ];
    }

    public function fullname()
    {
        return $this->fullname ?: $this->username;
    }

    public function getDepartmentBadge()
    {
        $html = '';

        foreach ($this->enumDepartment() as $department) {
            $html .= sprintf('<span class="badge bg-teal text-white">%s</span>', $department->description());
        }

        return $html;
    }

    public function getTeamBadge()
    {
        if ($this->team->exists) {
            return sprintf('<span class="badge bg-azure-lt">%s</span>', $this->team->name);
        }
    }

    public function getRoleBadge()
    {
        if ($this->isSuperadmin()) {
            return sprintf('<span class="badge bg-red text-white">%s</span>', trans('Superadmin'));
        }

        if($this->isSuperDepartmentNone() == false)
        {
            return sprintf('<span class="badge bg-pink text-pink-fg">%s</span>', $this->super_department->description());
        }

        if ($this->isRoleEmployee()) {
            return sprintf('<span class="badge bg-azure text-white">%s</span>', trans('Employee'));
        }

        $html = '';

        if($this->isRoleManager())
        {
            $html .= sprintf('<span class="badge bg-orange text-white">%s</span>', trans('Manager'));
        }

        if ($this->isRoleLeader()) {
            $html .= sprintf('<span class="badge bg-cyan text-white">%s</span>', trans('Leader'));
        }

        return $html;
    }

    public function getDepartmentForLeaderDown()
    {
        return $this->team->department;
    }

    public function enumDepartment(): array
    {
        if ($this->isRoleManager()) {
            return $this->managerDepartments->pluck('department')->toArray();
        }

        if ($this->team->department) {
            return [$this->team->department];
        }

        return [];
    }

    public function getAvatar()
    {
        return $this->avatar ? asset($this->avatar) : asset('public/images/avatar-user.png');
    }

    public function leaderTeam()
    {
        return $this->hasOne(Team::class, 'leader_id')->withDefault();
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id')->withDefault();
    }

    public function managerDepartments()
    {
        return $this->hasMany(AdminDepartment::class, 'admin_id');
    }

    public function workingTimes()
    {
        return $this->hasMany(WorkingTime::class, 'admin_id');
    }

    public function workingTimeToday()
    {
        return $this->hasOne(WorkingTime::class, 'admin_id')->today();
    }

    public function canWorkRemoteToday()
    {
        return $this->work_remote_date?->count() && array_search(now()->format('Y-m-d'), $this->work_remote_date->toArray()) !== false;
    }

    public function canCheckin()
    {

        $auth = $this->loadMissing(['workingTimeToday']);
        if (
            ($auth->workingTimeToday == null && check_normal_day()) || $this->canWorkRemoteToday()
        ) {
            return true;
        }
        return false;
    }


    public function canCheckout()
    {
        $auth = $this->loadMissing(['workingTimeToday']);

        return $auth->workingTimeToday ? true : false;
    }


    public function checkLocationAllowCheckInOut()
    {
        if ($this->canWorkRemoteToday()) {
            return true;
        }

        if ($this->latitude && $this->longitude) {
            $settings = app()->make('App\Models\Setting');

            $location = config('packages_workingtime.general.location');

            $distance = calculate_distance(
                $settings->getValue('location_latitude') ?? $location['latitude'],
                $settings->getValue('location_longitude') ?? $location['longitude'],
                $this->latitude,
                $this->longitude
            );

            // Kiểm tra khoảng cách giữa 2 điểm có lớn hơn bán kính cho phép hay không.
            if ($distance > ($settings->getValue('allow_radius_checkin_checkout') ?? config('packages_workingtime.general.allow_radius', 500))) {
                return false;
            }

            return true;
        }
        return false;
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class, 'admin_id');
    }

    public function calculateLeaveDaysForCurrentMonth(): int
    {
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();

        $leaveRequests = $this->leaveRequests()
            ->where('status', LeaveRequestStatus::Approved)
            ->where(function ($query) use ($currentMonthStart, $currentMonthEnd) {
                $query->whereBetween('start_date', [$currentMonthStart, $currentMonthEnd])
                    ->orWhereBetween('end_date', [$currentMonthStart, $currentMonthEnd])
                    ->orWhere(function ($subQuery) use ($currentMonthStart, $currentMonthEnd) {
                        $subQuery->where('start_date', '<', $currentMonthStart)
                            ->where('end_date', '>', $currentMonthEnd);
                    });
            })
            ->get();

        $leaveDays = 0;

        foreach ($leaveRequests as $leaveRequest) {
            $startDate = Carbon::parse($leaveRequest->start_date)->max($currentMonthStart);
            $endDate = Carbon::parse($leaveRequest->end_date ?? $leaveRequest->start_date)->min($currentMonthEnd);

            $days = $startDate->diffInDays($endDate) + 1;

            if ($leaveRequest->is_half_day) {
                $days -= 0.5;
            }

            $leaveDays += $days;
        }

        return $leaveDays;
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'assigns_projects', 'admin_id', 'project_id');
    }

    public function bankAccount()
    {
        return $this->hasOne(AdminBankAccount::class, 'admin_id')->withDefault();
    }

}
