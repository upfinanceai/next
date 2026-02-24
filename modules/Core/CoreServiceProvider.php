<?php

namespace Modules\Core;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Console\Commands\Install;

class CoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
            $this->commands([
                Install::class,
            ]);
        }
    }
}
