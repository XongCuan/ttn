<?php

namespace TCore\Notification\Providers;

use Illuminate\Support\ServiceProvider;
use TCore\Base\Traits\LoadAndPublishData;

class NotificationServiceProvider extends ServiceProvider
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