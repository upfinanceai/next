<?php

namespace App\Modules\Account\Actions;

use App\Models\Account;

class GetBalance
{
    public static function handle($owner_type, $owner_id, $currency, $type = 'available')
    {
        $account = Account::where([
            'owner_type' => $owner_type,
            'owner_id'   => $owner_id,
            'currency'   => $currency,
        ])->firstOrFail();

        return $account->balance;
    }
}
