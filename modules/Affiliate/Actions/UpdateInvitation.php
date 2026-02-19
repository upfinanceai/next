<?php

namespace Modules\Affiliate\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Customer\Models\Customer;

class UpdateInvitation
{
    use AsAction;

    public function handle(Customer $customer)
    {
        if (!$customer->affiliate_code) {
            return;
        }

        $invitor = Customer::where('referral_code', $customer->affiliate_code)->first();

        if (!$invitor) {
            return;
        }

        $customer->invited_by = $invitor->id;
        $customer->save();
    }

    public function asListener($event)
    {
        $this->handle($event->customer);
    }

}
