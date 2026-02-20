<?php

namespace Modules\Card;

use Illuminate\Support\ServiceProvider;

class CardServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
    }
}
