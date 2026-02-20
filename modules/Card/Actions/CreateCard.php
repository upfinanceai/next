<?php

namespace Modules\Card\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Actions\CreateAccount;
use Modules\Card\Contracts\CardProvider;

class CreateCard
{
    use AsAction;

    public function handle($user, $data, CardProvider $provider)
    {
        $card = $provider->createCard($data);
        $card->user()->associate($user);
        $card->save();

        // create card account
        CreateAccount::run('card', $card->id, $card->currency);
    }
}
