<?php

namespace Modules\Account\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Data\AccountData;
use Modules\Account\Enums\AccountStatus;
use Modules\Account\Models\Account;
use Modules\Core\Exceptions\LogicException;
use Modules\Core\Models\Currency;

class CreateAccount
{
    use AsAction;

    public function handle(AccountData $data): Account
    {
        // check currency exist
        $currency = Currency::active()->where('code', $data->currency)->first();
        if (empty($currency)) {
            throw new LogicException('Unsupport currency');
        }

        return Account::firstOrCreate([
            'owner_type' => $data->owner_type,
            'owner_id'   => $data->owner_id,
            'currency'   => $data->currency,
            'chain'      => $data->chain,
            'purpose'    => $data->purpose,
        ], [
            'category' => $data->category,
            'status'   => $data->status ?? AccountStatus::ACTIVE(),
            'number'   => $data->number ?? snowflake_id(),
        ]);
    }
}
