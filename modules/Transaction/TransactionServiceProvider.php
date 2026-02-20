<?php

namespace Modules\Transaction;

use Illuminate\Support\ServiceProvider;

class TransactionServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
    }
}
