<?php

namespace Modules\Card\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Actions\CreateAccount;
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
        CreateAccount::run('card', $card->id, $card->currency);

        return $card;
    }
}
