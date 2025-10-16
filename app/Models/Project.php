<?php

namespace App\Models;

use App\Enums\Project\ProjectPriority;
use App\Enums\Project\ProjectScale;
use App\Enums\Project\ProjectStatus;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use TCore\Base\Enums\Department;
use TCore\Base\Models\BaseModel;
use TCore\Outsource\Observers\ProjectObserver;

#[ObservedBy(ProjectObserver::class)]
class Project extends BaseModel
{
    protected $table = 'projects';

    protected $fillable = [
        'order_id',
        'team_id',
        'admin_id',
        'department',
        'name',
        'priority',
        'start_date',
        'end_date',
        'desc',
        'status',
        'scale',
        'demo_ontime',
        'demo_date'
    ];

    protected function casts()
    {
        return [
            'status' => ProjectStatus::class,
            'department' => Department::class,
            'priority' => ProjectPriority::class,
            'scale' => ProjectScale::class
        ];
    }

    public function getTeam()
    {
        return $this->teamInternal->id ? $this->teamInternal : $this->teamOutsource;
    }

    public function isPriority()
    {
        return $this->priority != ProjectPriority::Default;
    }

    public function isCompleted()
    {
        return $this->status == ProjectStatus::Done;
    }

    public function isDemo()
    {
        return $this->status == ProjectStatus::Demo;
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id')->withDefault(['fullname' => null]);
    }

    public function assigns()
    {
        return $this->belongsToMany(Admin::class, 'assigns_projects', 'project_id', 'admin_id');
    }

    public function teamInternal()
    {
        return $this->belongsTo(Team::class, 'team_id')->where('department', Department::Internal)->withDefault();
    }

    public function teamOutsource()
    {
        return $this->belongsTo(Team::class, 'team_id')->where('department', Department::Outsource)->withDefault();
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function requirement()
    {
        return $this->hasOne(ProjectRequirement::class, 'project_id')->withDefault();
    }
}
