<?php

namespace TCore\Superadmin\Observers;

use App\Models\Admin;
use TCore\Base\Enums\DefaultStatus;
use TCore\Base\Enums\Gender;

class AdminObserver
{
    /**
     * Handle the Job "creating" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function creating(Admin $admin)
    {
        $admin->username = $admin->email;
        $admin->status = DefaultStatus::Published;
        $admin->gender = Gender::Male;
    }

    /**
     * Handle the Admin "created" event.
     */
    public function created(Admin $admin): void
    {
        //
    }

    public function updating(Admin $admin): void
    {
        $admin->username = $admin->email;
    }

    /**
     * Handle the Admin "updated" event.
     */
    public function updated(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "deleted" event.
     */
    public function deleted(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "restored" event.
     */
    public function restored(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "force deleted" event.
     */
    public function forceDeleted(Admin $admin): void
    {
        //
    }
}
