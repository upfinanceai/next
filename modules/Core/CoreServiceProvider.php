<?php

namespace Modules\Core;

use Illuminate\Support\ServiceProvider;
use Modules\Account\Services\AccountService;
use Modules\Card\Services\CardService;
use Modules\Customer\Services\CustomerService;
use Modules\Deposit\Services\DepositService;
use Modules\Exchange\Services\ExchangeService;
use Modules\Transaction\Services\TransactionService;

class CoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/core.php', 'app');
        $this->app->bind('customer', CustomerService::class);
        $this->app->bind('card', CardService::class);
        $this->app->bind('deposit', DepositService::class);
        $this->app->bind('transaction', TransactionService::class);
        $this->app->bind('account', AccountService::class);
        $this->app->bind('exchange', ExchangeService::class);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
    }
}
