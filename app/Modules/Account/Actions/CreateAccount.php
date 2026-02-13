<?php

namespace App\Modules\Account\Actions;

use App\Models\Account;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateAccount
{
    use AsAction;

    public function handle($owner_type, $owner_id, $currency)
    {
        Account::firstOrCreate([
            'owner_type' => $owner_type,
            'owner_id'   => $owner_id,
            'currency'   => $currency,
        ]);
    }
}
