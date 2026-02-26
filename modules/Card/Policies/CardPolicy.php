<?php

namespace Modules\Card\Policies;

use Modules\Card\Models\Card;
use Modules\Customer\Models\Customer;

class CardPolicy
{
    public function canDeposit(Customer $customer, Card $card)
    {
        if ($card->customer_id != $customer->id) {
            return false;
        }

        if ($card->status != 'active') {
            return false;
        }

        return true;
    }
}
