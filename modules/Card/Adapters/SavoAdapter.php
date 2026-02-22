<?php

namespace Modules\Card\Adapters;

use Modules\Card\Contracts\CardProvider;
use Modules\Card\Models\Card;

class SavoAdapter implements CardProvider
{

    public function createCard($data): Card
    {
        return Card::create([
        ]);
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
