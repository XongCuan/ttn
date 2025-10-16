<?php

namespace TCore\Acl\Traits;

use App\Models\Team;
use TCore\Base\Enums\Department;
use TCore\Base\Enums\SuperDepartment;

trait PermissionTrait
{
    public function isSuperadmin()
    {
        return $this->is_superadmin;
    }

    public function hasShipRoleAccounting()
    {
        return $this->hasShipRole(Department::Accounting);
    }

    public function hasManagerShipRoleAccounting()
    {
        return $this->hasManagerShipRole(Department::Accounting);
    }

    public function hasManagerShipRoleWebadmin()
    {
        return $this->hasManagerShipRole(Department::Webadmin);
    }

    public function hasManagerShipRoleInternal()
    {
        return $this->hasManagerShipRole(Department::Internal);
    }

    public function hasManagerShipRoleOutsource()
    {
        return $this->hasManagerShipRole(Department::Outsource);
    }

    public function hasLeaderShipRoleOutsource()
    {
        return $this->hasLeaderShipRole(Department::Outsource);
    }

    public function hasLeaderShipRoleWebadmin()
    {
        return $this->hasLeaderShipRole(Department::Webadmin);
    }

    public function hasManagerShipRoleMkt()
    {
        return $this->hasManagerShipRole(Department::Marketing);
    }

    public function hasLeaderShipRoleMkt()
    {
        return $this->hasLeaderShipRole(Department::Marketing);
    }

    public function hasShipRoleInternal()
    {
        return $this->hasShipRole(Department::Internal);
    }

    public function hasShipRoleOutsource()
    {
        return $this->hasShipRole(Department::Outsource);
    }

    public function hasShipRoleWebadmin()
    {
        return $this->hasShipRole(Department::Webadmin);
    }

    public function hasShipRoleMkt()
    {
        return $this->hasShipRole(Department::Marketing);
    }

    public function hasShipRoleSales()
    {
        return $this->hasShipRole(Department::Sales);
    }

    public function hasShipRole(Department $department)
    {
        return $this->isDepartment($department)
            || $this->hasLeaderShipRole($department);
    }

    public function hasLeaderShipRoleSales()
    {
        return $this->hasLeaderShipRole(Department::Sales);
    }

    public function hasLeaderShipRole(Department $department)
    {
        return $this->isLeader($department)
            || $this->hasManagerShipRole($department);
    }

    public function hasManagerShipRoleSales()
    {
        return $this->hasManagerShipRole(Department::Sales);
    }

    public function hasManagerShipRole(Department $department)
    {
        return $this->isManager($department)
            || $this->isSuperDepartment($department->super())
            || $this->isSuperadmin();
    }

    public function canAssignSuperDepartment()
    {
        return $this->isSuperadmin() == false;
    }

    public function canAssignManager()
    {
        return $this->isSuperadmin() == false
            && $this->isSuperDepartmentNone();
            // && $this->isRoleLeader() == false
            // && $this->team_id == null;
    }

    public function isSuperDepartmentNone()
    {
        return $this->isSuperDepartment(SuperDepartment::None);
    }

    public function isSuperDepartmentBD()
    {
        return $this->isSuperDepartment(SuperDepartment::BussinessDevelopment);
    }

    public function isSuperDepartment(SuperDepartment $superDepartment)
    {
        return $this->super_department == $superDepartment;
    }

    public function isManagerOutSource()
    {
        return $this->isManager(Department::Outsource);
    }

    public function isManagerSales()
    {
        return $this->isManager(Department::Sales);
    }

    public function isManagerMKT()
    {
        return $this->isManager(Department::Marketing);
    }

    public function isLeaderOfTeam(Team $team)
    {
        return $this->id == $team->leader_id;
    }

    public function isLeader(Department $department)
    {
        return $this->isDepartment($department) && $this->id == $this->team->leader_id;
    }

    public function isDepartment(Department $department)
    {
        return $this->team->department == $department || $this->isManager($department);
    }

    public function isManager(Department $department)
    {
        return $this->managerDepartments->contains('department', $department);
    }

    public function isRoleLeader()
    {
        return $this->leaderTeam->id;
    }

    public function isRoleManager()
    {
        return $this->managerDepartments->count() > 0;
    }

    public function isRoleSuperManager()
    {
        return $this->super_department !== null && $this->super_department != SuperDepartment::None;
    }

    public function isRoleEmployee()
    {
        return $this->isRoleLeader() == false
            && $this->isRoleManager() == false
            && $this->isRoleSuperManager() == false
            && $this->isSuperadmin() == false;
    }

    public function isAnyDepartment(array $departments)
    {
        foreach ($departments as $department) {
            if ($this->isDepartment($department)) {
                return true;
            }
        }

        return false;
    }
}