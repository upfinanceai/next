<?php

namespace Modules\Account\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Data\AccountData;
use Modules\Account\Enums\AccountCategory;
use Modules\Account\Models\Account;

class GetCustomerAccount
{
    use AsAction;

    public function handle($customer, $currency, $create = true): Account
    {
        return GetAccount::run(AccountData::from([
            'owner_type' => 'customer',
            'owner_id' => $customer->id,
            'currency' => $currency,
            'category' => AccountCategory::LIABILITY(),
        ]), $create);
    }
}
