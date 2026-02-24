<?php

namespace Modules\Customer\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Actions\CreateAccount;
use Modules\Account\Data\AccountData;
use Modules\Account\Enums\AccountCategory;
use Modules\Account\Enums\AccountStatus;
use Modules\Customer\Events\CustomerEvent;
use Modules\Customer\Models\Customer;

class EnsureCustomerAccount
{
    use AsAction;

    public function handle(Customer $customer)
    {
        $currencies = ['USD', 'USDT', 'BNB'];
        foreach ($currencies as $currency) {
            CreateAccount::run(AccountData::from([
                'owner_type' => 'customer',
                'owner_id'   => $customer->id,
                'currency'   => $currency,
                'status'     => AccountStatus::ACTIVE(),
                'category'   => AccountCategory::LIABILITY(),
            ]));
        }
    }

    public function asListener(CustomerEvent $event)
    {
        $this->handle($event->customer);
    }
}
