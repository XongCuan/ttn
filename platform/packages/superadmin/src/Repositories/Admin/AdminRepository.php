<?php

namespace TCore\Superadmin\Repositories\Admin;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\AdminDepartment;
use TCore\Support\Repositories\Eloquent\RepositoryAbstract;

class AdminRepository extends RepositoryAbstract implements AdminRepositoryInterface
{
    public function getModel(){
        return Admin::class;
    }

    public function syncManagerDepartment(Admin $admin, array $departments)
    {
        $managerDepartments = $admin->loadMissing(['managerDepartments'])->managerDepartments;

        $delete = [];

        foreach($managerDepartments as $item)
        {
            if(in_array($item->department->value, $departments) == false)
            {
               array_push($delete, $item->department->value);
            }else {
                unset($departments[array_search($item->department->value, $departments)]);
            }
        }

        if(count($delete))
        {
            AdminDepartment::whereIn('department', $delete)->delete();
        }

        if(count($departments))
        {
            $departments = array_map(fn($item) => ['department' => $item], $departments);

            $admin->managerDepartments()->createMany($departments);
        }
    }
}