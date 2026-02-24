<?php

namespace Modules\Customer\Actions\Mails;

use Lorisleiva\Actions\Concerns\AsAction;
use Mail;
use Modules\Customer\Events\CustomerEvent;
use Modules\Customer\Mails\WelcomeMail;
use Modules\Customer\Models\Customer;

class SendWelcomeMail
{
    use AsAction;

    public function handle(Customer $customer)
    {
        Mail::to($customer->email)->queue(new WelcomeMail($customer));
    }

    public function asListener(CustomerEvent $event)
    {
        if (($event->customer ?? null) instanceof Customer) {
            $this->handle($event->customer);
        }
    }
}
