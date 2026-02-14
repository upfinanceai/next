<?php

namespace App\Modules\Card\Adapters;

use App\Models\Card;
use App\Modules\Card\Contracts\CardProvider;

class WasabiAdapter implements CardProvider
{

    public function createCard($data): Card
    {
        // TODO: call wasabi api
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
