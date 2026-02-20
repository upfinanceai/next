<?php

namespace Modules\Card\Adapters;

use Modules\Card\Contracts\CardProvider;
use Modules\Card\Models\Card;

class SavoAdapter implements CardProvider
{

    public function createCard($data): Card
    {
        return Card::create([
            'card_design_id' => $data['card_design_id'],
            'holder_name'    => $data['holder_name'],
            'last_no'        => rand(1000, 9999),
            'currency'       => 'USD',
            'status'         => 'active',
        ]);
    }

    public function freezeCard($card)
    {
        // TODO: Implement freezeCard() method.
    }
}
