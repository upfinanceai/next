<?php

namespace Modules\Support;

use Illuminate\Support\ServiceProvider;
use Modules\Support\Console\Commands\Install;

class SupportServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            Install::class,
        ]);
    }
}
