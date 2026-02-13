<?php

namespace App\Modules\Account\Actions;

use App\Models\Account;

class GetCashAccount
{
    public static function handle($user, $currency)
    {
        return Account::where([
            'owner_type' => 'user',
            'owner_id'   => $user->id,
            'currency'   => $currency,
        ])->first();
    }
}
