<?php

namespace TCore\Outsource\Models;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Builder;
use TCore\Base\Enums\Department;

class Employee extends Admin
{
    protected static function booted(): void
    {
        static::addGlobalScope('employee_outsource', function(Builder $builder) {

            $builder->currentDermartment();
        });
    }

    public function scopeCurrentDermartment($q)
    {
        $q->whereHas('team', fn($q) => $q->where('department', Department::Outsource));
    }
    
    public function scopeOrCurrentDermartment($q)
    {
        $q->orWhereHas('team', fn($q) => $q->where('department', Department::Outsource));
    }

    public function scopeCurrentHasManager($q, $team_id = null)
    {
        $q->where(function($query) use ($team_id) {
            $query->currentDermartment();
            
            if($team_id)
            {
                $query->where('team_id', $team_id);
            }
        });
        
        $q->orManager();
    }

    public function scopeManager($q)
    {
        $q->whereHas('managerDerpatments', fn($query) => $query->where('department', Department::Outsource));
    }

    public function scopeOrManager($q)
    {
        $q->orWhereHas('managerDepartments', fn($query) => $query->where('department', Department::Outsource));
    }
}