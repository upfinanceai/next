<?php

namespace App\Modules\Account\Actions;

use App\Models\Account;
use Lorisleiva\Actions\Concerns\AsAction;

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
