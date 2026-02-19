<?php

namespace Modules\Affiliate;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Modules\Affiliate\Actions\UpdateInvitation;
use Modules\Customer\Events\CustomerCreatedEvent;

class AffiliateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Event::listen(
            CustomerCreatedEvent::class,
            UpdateInvitation::class
        );

        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
    }
}
