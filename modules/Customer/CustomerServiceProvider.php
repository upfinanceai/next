<?php

namespace Modules\Customer;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Modules\Customer\Models\Customer;

class CustomerServiceProvider extends ServiceProvider
{

    public function register()
    {
        Relation::enforceMorphMap([
            'customer' => Customer::class,
        ]);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/Resources/Views', 'upfinance.customer');
    }
}
