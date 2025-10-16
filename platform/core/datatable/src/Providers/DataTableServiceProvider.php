<?php

namespace TCore\DataTable\Providers;

use Illuminate\Support\ServiceProvider;
use TCore\Base\Traits\LoadAndPublishData;

class DataTableServiceProvider extends ServiceProvider
{
    use LoadAndPublishData;

    public function boot()
    {
        $this->loadViews();
    }
}