<?php

namespace Modules\Account\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Models\Account;

class GetSystemAccount
{
    use AsAction;

    public function handle($owner_id, $currency, $chain = null, $create = true)
    {
        $account = Account::where([
            'owner_type' => 'system',
            'owner_id'   => $owner_id,
            'currency'   => $currency,
            'chain' => $chain,
        ])->first();

        if (empty($account) && $create) {
            $account = CreateAccount::run(
                owner_type: 'system',
                owner_id: $owner_id,
                currency: $currency,
                chain: $chain
            );
        }

        return $account;
    }
}
