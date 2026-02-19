<?php

namespace Modules\Customer\Actions;

use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Customer\Data\CustomerData;
use Modules\Customer\Events\CustomerCreatedEvent;
use Modules\Customer\Mails\WelcomeMail;
use Modules\Customer\Models\Customer;

class CreateCustomer
{
    use AsAction;

    public function handle(CustomerData $data)
    {
        // check user exist
        $customer = Customer::create([
            'name'           => $data->name,
            'email'          => $data->email,
            'affiliate_code' => $data->affiliate_code,
            'password'       => bcrypt($data->password),
            'meta'           => $data->meta,
            'signup_ip'      => request()->ip(),
        ]);

        CustomerCreatedEvent::dispatch($customer);
        Mail::to($customer->email)->queue((new WelcomeMail($customer))->onQueue('email'));
        return $customer;
    }
}
