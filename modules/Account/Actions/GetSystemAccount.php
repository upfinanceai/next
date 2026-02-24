<?php

namespace Modules\Account\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Data\AccountData;
use Modules\Account\Enums\AccountCategory;

class GetSystemAccount
{
    use AsAction;

    public function handle($currency, $purpose = null, $chain = null, $create = true)
    {
        return GetAccount::run(AccountData::from([
            'owner_type' => 'system',
            'owner_id' => 1,
            'currency' => $currency,
            'chain' => $chain,
            'purpose'  => $purpose,
            'category' => AccountCategory::ASSET(),
        ]), $create);
    }
}
