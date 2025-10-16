<?php

namespace TCore\Support\Providers;

use Illuminate\Support\ServiceProvider;
use TCore\Base\Traits\LoadAndPublishData;

class SupportServiceProvider extends ServiceProvider
{
    use LoadAndPublishData;

    public function register()
    {
        $this->loadHeplers();
    }
}