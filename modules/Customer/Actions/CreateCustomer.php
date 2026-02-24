<?php

namespace Modules\Customer\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Customer\Data\CustomerData;
use Modules\Customer\Events\CustomerCreatedEvent;
use Modules\Customer\Models\Customer;

class CreateCustomer
{
    use AsAction;

    public function handle(CustomerData $data)
    {
        // check user exist
        $customer = Customer::create([
            'name'           => $data->name,
            'number'         => snowflake_id(),
            'email'          => $data->email,
            'status'         => 'active',
            'affiliate_code' => $data->affiliate_code,
            'password'       => bcrypt($data->password),
            'meta'           => $data->meta,
            'signup_ip'      => request()->ip(),
        ]);

        CustomerCreatedEvent::dispatch($customer);

        return $customer;
    }
}
