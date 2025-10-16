<?php

namespace TCore\Sales\Providers;

use Illuminate\Support\ServiceProvider;
use TCore\Base\Traits\LoadAndPublishData;

class SalesServiceProvider extends ServiceProvider
{
    use LoadAndPublishData;

    protected $repositories = [
        'TCore\Sales\Repositories\Order\OrderRepositoryInterface' => 'TCore\Sales\Repositories\Order\OrderRepository'
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