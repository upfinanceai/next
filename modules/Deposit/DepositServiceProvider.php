<?php

namespace Modules\Deposit;

use Illuminate\Support\ServiceProvider;

class DepositServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
    }
}
