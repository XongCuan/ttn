<?php

namespace TCore\Dashboard\Providers;

use Illuminate\Support\ServiceProvider;
use TCore\Base\Traits\LoadAndPublishData;

class DashboardServiceProvider extends ServiceProvider
{
    use LoadAndPublishData;

    public function boot()
    {
        $this->loadRoutes()->loadViews();
    }
}