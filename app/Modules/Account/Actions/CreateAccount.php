<?php

namespace App\Modules\Account\Actions;

use App\Models\Account;

class CreateAccount
{
    public static function handle($owner_type, $owner_id, $currency)
    {
        Account::firstOrCreate([
            'owner_type' => $owner_type,
            'owner_id'   => $owner_id,
            'currency'   => $currency,
            'type'       => 'available',
        ]);
        Account::firstOrCreate([
            'owner_type' => $owner_type,
            'owner_id'   => $owner_id,
            'currency'   => $currency,
            'type'       => 'frozen',
        ]);
    }
}
