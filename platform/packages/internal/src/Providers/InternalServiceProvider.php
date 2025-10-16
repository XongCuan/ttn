<?php

namespace TCore\Internal\Providers;

use Illuminate\Support\ServiceProvider;
use TCore\Base\Traits\LoadAndPublishData;

class InternalServiceProvider extends ServiceProvider
{
    use LoadAndPublishData;

    protected $repositories = [
        'TCore\Internal\Repositories\Project\ProjectRepositoryInterface' => 'TCore\Internal\Repositories\Project\ProjectRepository'
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