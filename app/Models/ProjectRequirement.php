<?php

namespace App\Models;

use App\Enums\Project\ProjectRequirementStatus;
use TCore\Base\Models\BaseModel;

class ProjectRequirement extends BaseModel
{
    //
    protected $table = 'project_requirements';

    protected $fillable = [
        'order_id', 'team_id', 'project_id', 'title', 'content', 'assigned_by', 'status', 'start_date', 'end_date', 'demo_date', 'demo_ontime'
    ];

    protected function casts()
    {
        return [
            'status' => ProjectRequirementStatus::class
        ];
    }

    public function isDone()
    {
        return $this->status == ProjectRequirementStatus::Done;
    }

    public function isFinish()
    {
        return $this->status == ProjectRequirementStatus::Finish;
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id')->withDefault();
    }

    public function assign()
    {
        return $this->belongsTo(Admin::class, 'assigned_by')->withDefault();
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id')->withDefault();
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id')->withDefault();
    }

    public function scopeDone($query)
    {
        $query->where('status', ProjectRequirementStatus::Done);
    }
}
