<?php

namespace Modules\Core;

use Illuminate\Support\ServiceProvider;
use Modules\Api\Services\ApiAuthService;
use Modules\Card\Services\CardService;
use Modules\Customer\Services\CustomerService;
use Modules\Deposit\Services\DepositService;

class CoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/core.php', 'app');
        $this->app->bind('customer', CustomerService::class);
        $this->app->bind('card', CardService::class);
        $this->app->bind('deposit', DepositService::class);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
    }
}
