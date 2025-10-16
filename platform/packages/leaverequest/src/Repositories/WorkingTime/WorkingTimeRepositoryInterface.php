<?php

namespace TCore\LeaveRequest\Repositories\WorkingTime;

use App\Models\Admin;
use TCore\Support\Repositories\Interfaces\RepositoryInterface;

interface WorkingTimeRepositoryInterface extends RepositoryInterface
{
    public function checkin(Admin $admin);   
    
    public function checkout(Admin $admin);   
}