<?php

namespace App\Modules\Account\Actions;

use App\Models\Account;
use Lorisleiva\Actions\Concerns\AsAction;

class GetUserAccount
{
    use AsAction;

    public function handle($user, $currency, $create = true)
    {
        $account = Account::where([
            'owner_type' => 'user',
            'owner_id'   => $user->id,
            'currency'   => $currency,
        ])->first();

        if (empty($account) && $create) {
            $account = CreateAccount::run(owner_type: 'user', owner_id: $user->id, currency: $currency);
        }

        return $account;
    }
}
