<?php

namespace TCore\Webadmin\Providers;

use Illuminate\Support\ServiceProvider;
use TCore\Base\Traits\LoadAndPublishData;

class WebadminServiceProvider extends ServiceProvider
{
    use LoadAndPublishData;

    public function register()
    {
        $this->loadHeplers()->loadConfig();
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