<?php

namespace Modules\WebApp;


use Illuminate\Support\ServiceProvider;

class WebAppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/webapp.php', 'webapp');
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/Resources/Views', 'webapp');
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
    }
}
