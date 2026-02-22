<?php

namespace Modules\Account\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Data\AccountData;
use Modules\Account\Enums\AccountCategory;

class GetSystemAccount
{
    use AsAction;

    public function handle($owner_id, $currency, $chain = null, $create = true)
    {
        return GetAccount::run(AccountData::from([
            'owner_type' => 'system',
            'owner_id' => $owner_id,
            'currency' => $currency,
            'chain' => $chain,
            'category' => AccountCategory::ASSET(),
        ]), $create);
    }
}
