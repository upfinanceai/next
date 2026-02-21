<?php

namespace Modules\Card;

use Illuminate\Support\ServiceProvider;

class CardServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/card.php', 'card');
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
    }
}
