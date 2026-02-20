<?php

namespace Modules\Account\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Models\Account;

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
