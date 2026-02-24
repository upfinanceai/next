<?php

namespace Modules\Customer;

use Event;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Modules\Customer\Actions\EnsureCustomerAccount;
use Modules\Customer\Actions\Mails\SendWelcomeMail;
use Modules\Customer\Events\CustomerCreatedEvent;
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
        $this->loadViewsFrom(__DIR__ . '/Resources/Views', 'customer');
        $this->registerEventListeners();
    }

    protected function registerEventListeners()
    {
        // Send welcome mail
        Event::listen(CustomerCreatedEvent::class, SendWelcomeMail::class);

        // Ensure customer account
        Event::listen(CustomerCreatedEvent::class, EnsureCustomerAccount::class);
    }
}
