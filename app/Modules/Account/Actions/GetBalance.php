<?php

namespace App\Modules\Account\Actions;

use App\Models\Account;

class GetBalance
{
    public static function handle($owner_type, $owner_id, $currency, $type = 'total')
    {
        if ($type === 'total') {
            $account_avaiable = Account::where([
                'owner_type' => $owner_type,
                'owner_id'   => $owner_id,
                'currency'   => $currency,
                'type'       => 'available',
            ])->firstOrFail();

            $account_frozen = Account::where([
                'owner_type' => $owner_type,
                'owner_id'   => $owner_id,
                'currency'   => $currency,
                'type'       => 'frozen',
            ])->firstOrFail();

            return GetAccountBalance::handle($account_avaiable) + GetAccountBalance::handle($account_frozen);
        }

        $account = Account::where([
            'owner_type' => $owner_type,
            'owner_id'   => $owner_id,
            'currency'   => $currency,
            'type'       => $type,
        ])->firstOrFail();

        return GetAccountBalance::handle($account);
    }
}
