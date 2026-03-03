<?php

namespace Modules\Card;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Services\FeeService;
use Modules\Customer\Models\Customer;

class CardServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/card.php', 'card');
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->registerCardFees();
    }

    protected function registerCardFees()
    {
        FeeService::macro('getCardFee', function (Customer $customer, $payload) {
            return 123;
        });
    }
}
