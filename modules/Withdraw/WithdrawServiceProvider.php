<?php

namespace Modules\Withdraw;

use Illuminate\Support\ServiceProvider;

class WithdrawServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
    }
}
