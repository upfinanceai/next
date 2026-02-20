<?php

namespace Modules\Topup;

use Illuminate\Support\ServiceProvider;

class TopupServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
    }
}
