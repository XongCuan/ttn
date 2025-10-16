<?php

namespace TCore\LeaveRequest\Providers;

use Illuminate\Support\ServiceProvider;
use TCore\Base\Traits\LoadAndPublishData;

class LeaveRequestServiceProvider extends ServiceProvider
{
    use LoadAndPublishData;

    protected $repositories = [
        'TCore\LeaveRequest\Repositories\LeaveRequest\LeaveRequestRepositoryInterface' => 'TCore\LeaveRequest\Repositories\LeaveRequest\LeaveRequestRepository'
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