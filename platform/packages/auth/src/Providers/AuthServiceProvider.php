<?php

namespace TCore\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use TCore\Base\Traits\LoadAndPublishData;

class AuthServiceProvider extends ServiceProvider
{
    use LoadAndPublishData;

    public function register()
    {
        $this->loadHeplers()->loadConfig(exclude: ['auth']);
        
        // Thêm cấu hình guard vào Auth config tại runtime
        config(require $this->getPath('config/auth.php'));
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