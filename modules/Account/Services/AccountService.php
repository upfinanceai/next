<?php

namespace Modules\Account\Services;

use Modules\Account\Actions\GetAccounts;
use Modules\Account\Actions\QueryAccount;
use Modules\Account\Data\AccountData;
use Modules\Account\Enums\AccountCategory;
use Modules\Core\Abstracts\Service;
use Modules\Core\Enums\CurrencyType;
use Modules\Core\Models\Currency;

class AccountService extends Service
{
    public function initCustomerCashAccounts($customer)
    {
        $currencies = Currency::active()->where('type', CurrencyType::FIAT())->get();
        foreach ($currencies as $currency) {
            QueryAccount::run(AccountData::from([
                'owner_type' => 'customer',
                'owner_id'   => $customer->id,
                'currency'   => $currency->code,
                'purpose'    => 'cash',
                'category'   => AccountCategory::LIABILITY(),
            ]));
        }
    }

    public function getCustomerCashAccounts($customer)
    {
        return GetAccounts::run(AccountData::from([
            'owner_type' => 'customer',
            'owner_id'   => $customer->id,
            'purpose'    => 'cash',
        ]));
    }
}
