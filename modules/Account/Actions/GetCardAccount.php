<?php

namespace Modules\Account\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Models\Account;

class GetCardAccount
{
    use AsAction;

    public function handle($card, $create = true): Account
    {
        $account = Account::where([
            'owner_type' => 'card',
            'owner_id'   => $card->id,
            'currency'   => $card->currency,
        ])->first();

        if (empty($account) && $create) {
            $account = CreateAccount::run(
                owner_type: 'card',
                owner_id: $card->id,
                currency: $card->currency
            );
        }

        return $account;
    }
}
