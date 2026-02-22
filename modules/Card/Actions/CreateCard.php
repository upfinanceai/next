<?php

namespace Modules\Card\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Actions\CreateAccount;
use Modules\Account\Data\AccountData;
use Modules\Account\Enums\AccountCategory;
use Modules\Account\Enums\AccountStatus;
use Modules\Card\Contracts\CardProvider;
use Modules\Customer\Models\Customer;

class CreateCard
{
    use AsAction;

    public function handle(Customer $customer, $data, CardProvider $provider)
    {
        $card = $provider->createCard($data);
        $card->customer()->associate($customer);
        $card->save();

        // create card account
        CreateAccount::run(AccountData::from([
            'owner_type' => 'card',
            'owner_id'   => $card->id,
            'currency'   => $data['currency'],
            'status'     => AccountStatus::ACTIVE(),
            'category'   => AccountCategory::LIABILITY(),
        ]));

        return $card;
    }
}
