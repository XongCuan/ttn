<?php

namespace Theme\Cms\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use TCore\Base\Traits\LoadAndPublishData;
use Theme\Cms\Views\Composers\Notification;

class CMSServiceProvider extends ServiceProvider
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
        ->loadComponents(type: 'Theme');

        View::composer(
            ['themes_cms::layouts.notification'],
            Notification::class
        );
    }
}