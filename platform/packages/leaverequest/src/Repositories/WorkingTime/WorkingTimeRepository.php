<?php

namespace TCore\LeaveRequest\Repositories\WorkingTime;

use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use App\Models\WorkingTime;
use TCore\Support\Repositories\Eloquent\RepositoryAbstract;

class WorkingTimeRepository extends RepositoryAbstract implements WorkingTimeRepositoryInterface
{
    public function getModel()
    {
        return WorkingTime::class;
    }

    public function checkin(Admin $admin)
    {
        if ($admin->canCheckin()) {
            $admin->workingTimes()->create([
                'date' => now(),
                'check_in' => now()
            ]);

            if ($admin->canWorkRemoteToday()) {
                $admin->update([
                    'work_remote_date' => array_values(array_diff($admin->work_remote_date->toArray(), [now()->format('Y-m-d')]))
                ]);
            }

            return true;
        }

        return false;
    }

    public function checkout(Admin $admin)
    {
        if ($admin->canCheckout()) {
            $admin->workingTimeToday()->update(
                [
                    'check_out' => now()
                ]
            );
            return true;
        }

        return false;
    }
}
