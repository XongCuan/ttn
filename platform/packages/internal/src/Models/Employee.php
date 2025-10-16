<?php

namespace TCore\Internal\Models;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Builder;
use TCore\Base\Enums\Department;

class Employee extends Admin
{
    protected static function booted(): void
    {
        static::addGlobalScope('employee_internal', function(Builder $builder) {

            $builder->whereHas('team', function($q) {

                $q->where('department', Department::Internal);

            })->whereDoesntHave('team', function($q) {

                $q->whereColumn('leader_id', 'admins.id');

            });
        });
    }
}