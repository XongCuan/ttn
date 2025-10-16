<?php

namespace TCore\Superadmin\Repositories\Admin;

use App\Models\Admin;
use TCore\Support\Repositories\Interfaces\RepositoryInterface;

interface AdminRepositoryInterface extends RepositoryInterface
{
    public function syncManagerDepartment(Admin $admin, array $departments);
}