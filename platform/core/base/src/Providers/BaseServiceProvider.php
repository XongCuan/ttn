<?php

namespace TCore\Base\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use TCore\Base\Http\Responses\ResponseMacro;
use TCore\Base\Supports\Utilities;
use TCore\Base\Traits\LoadAndPublishData;

class BaseServiceProvider extends ServiceProvider
{
    use LoadAndPublishData;

    public function register()
    {
        $this->loadHeplers()->loadConfig();

        $this->app->singleton('utilities', function ($app) {
            return new Utilities();
        });
    }

    public function boot()
    {
        $this->loadMigrations()
        ->loadRoutes()
        ->loadViews()
        ->loadLanguages()
        ->loadComponents();

        Schema::defaultStringLength(191);

        ResponseMacro::register();

        Paginator::useBootstrapFive();
    }
}