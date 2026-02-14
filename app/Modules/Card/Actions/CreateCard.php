<?php

namespace App\Modules\Card\Actions;

use App\Modules\Account\Actions\CreateAccount;
use App\Modules\Card\Contracts\CardProvider;
use Lorisleiva\Actions\Concerns\AsAction;

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
