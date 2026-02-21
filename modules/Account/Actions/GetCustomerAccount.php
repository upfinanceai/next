<?php

namespace Modules\Account\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Models\Account;

class GetCustomerAccount
{
    use AsAction;

    public function handle($customer, $currency, $create = true): Account
    {
        $account = Account::where([
            'owner_type' => 'customer',
            'owner_id'   => $customer->id,
            'currency'   => $currency,
        ])->first();

        if (empty($account) && $create) {
            $account = CreateAccount::run(owner_type: 'customer', owner_id: $customer->id, currency: $currency);
        }

        return $account;
    }
}
