<?php

namespace App\Modules\Account\Actions;

use App\Models\Account;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateAccount
{
    use AsAction;

    public function handle($owner_type, $owner_id, $currency, $chain = null): Account
    {
        if (!empty($chain)) {
            $type = 'crypto';
        } else {
            $type = 'fiat';
        }
        return Account::firstOrCreate([
            'owner_type' => $owner_type,
            'owner_id'   => $owner_id,
            'currency'   => $currency,
            'type'  => $type,
            'chain' => $chain,
        ], [
            'status' => 'active',
        ]);
    }
}
