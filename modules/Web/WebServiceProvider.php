<?php

namespace Modules\Web;


use Illuminate\Support\ServiceProvider;

class WebServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/web.php', 'web');
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/Resources/Views', 'web');
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
    }
}
