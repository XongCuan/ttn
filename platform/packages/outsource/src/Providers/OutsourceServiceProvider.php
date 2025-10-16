<?php

namespace TCore\Outsource\Providers;

use Illuminate\Support\ServiceProvider;
use TCore\Base\Traits\LoadAndPublishData;

class OutsourceServiceProvider extends ServiceProvider
{
    use LoadAndPublishData;

    protected $repositories = [
        'TCore\Outsource\Repositories\Project\ProjectRepositoryInterface' => 'TCore\Outsource\Repositories\Project\ProjectRepository'
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