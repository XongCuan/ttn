<?php

namespace App\Models;

use TCore\Base\Enums\Department;
use TCore\Base\Models\BaseModel;

class Team extends BaseModel
{
    //
    protected $table = 'teams';

    protected $fillable = [
        'name', 'leader_id', 'department'
    ];

    protected function casts()
    {
        return [
            'department' => Department::class
        ];
    }

    public function isOf(Admin $admin)
    {
        return $this->id == $admin->team_id;
    }

    public function isLeader(Admin $admin)
    {
        return $this->leader_id == $admin->id;
    }

    public function getLeader()
    {
        if($this->relationLoaded('members'))
        {
            return $this->members->where('id', $this->leader_id)->first();
        }

        return $this->leader;
    }

    public function leader()
    {
        return $this->belongsTo(Admin::class, 'leader_id')->withDefault(['fullname' => null]);
    }

    public function members()
    {
        return $this->hasMany(Admin::class, 'team_id');
    }

    public function managers()
    {
        return $this->hasManyThrough(
            Admin::class, 
            AdminDepartment::class, 
            'department', //khóa ngoại trong bảng admin_departments
            'id', //khóa ngoại trong bảng admins
            'department', // Khóa chính của bảng team
            'admin_id' // Khóa chính của bảng admin_departments
        );
    }
}
