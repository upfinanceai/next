<?php

namespace Modules\Api;

use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/api.php', 'api');
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/Routes/api.php');
    }
}
