<?php

namespace Modules\Card\Adapters;

use Modules\Card\Contracts\CardProvider;
use Modules\Card\Models\Card;
use Modules\Core\Library\WasabiCardApiClient;

class WasabiAdapter implements CardProvider
{

    public function createCard($data): Card
    {
        /**
         * [
         *'holderId' => 1,
         *'cardTypeId' => 1,
         * 'amount' =>1
         * ]
         */
        $wasabiCard = WasabiCardApiClient::make()->createCard($data);
        $card       = Card::create([
            'provider'    => 'wasabi',
            'external_id' => $wasabiCard['cardNo'],
            'currency'    => $wasabiCard['currency'],
            'meta'        => $wasabiCard,
        ]);
        return $card;
    }

    public function freezeCard($card)
    {
        // TODO: Implement freezeCard() method.
    }

    public function deposit($card, $amount)
    {
        // TODO: Implement deposit() method.
    }

    public function withdraw($card, $amount)
    {
        // TODO: Implement withdraw() method.
    }
}
