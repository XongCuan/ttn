<?php

namespace TCore\Superadmin\Providers;

use Illuminate\Support\ServiceProvider;
use TCore\Base\Traits\LoadAndPublishData;
use TCore\Superadmin\Jobs\UpdateAdminLeaveDay;

class SuperadminServiceProvider extends ServiceProvider
{
    use LoadAndPublishData;

    protected $repositories = [
        'TCore\Superadmin\Repositories\Admin\AdminRepositoryInterface' => 'TCore\Superadmin\Repositories\Admin\AdminRepository'
    ];

    public function register()
    {
        $this->loadHeplers()->loadConfig();

        foreach ($this->repositories as $interface => $implement) {
            $this->app->singleton($interface, $implement);
        }
    }

    public function boot()
    {
        $this->loadMigrations()
        ->loadRoutes()
        ->loadViews()
        ->loadLanguages()
        ->loadComponents();
    }
}