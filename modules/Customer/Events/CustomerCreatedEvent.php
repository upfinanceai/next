<?php

namespace Modules\Customer\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Modules\Customer\Models\Customer;

class CustomerCreatedEvent
{
    use Dispatchable;

    public function __construct(
        public Customer $customer
    ) {
    }
}
