<?php

namespace Modules\Core;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Console\Commands\Install;

class CoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            Install::class,
        ]);
    }
}
