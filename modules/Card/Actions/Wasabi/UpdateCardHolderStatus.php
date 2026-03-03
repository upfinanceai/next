<?php

namespace Modules\Card\Actions\Wasabi;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Card\Models\WasabiCardHolder;
use Modules\Core\Library\WasabiCardApiClient;

class UpdateCardHolderStatus
{
    use AsAction;

    public function handle(WasabiCardHolder $cardHolder)
    {
        $result = WasabiCardApiClient::make()->getCardHolderList([
            'holderId' => $cardHolder->card_holder_id,
        ]);

        if (($result['records'][0]['holderId'] ?? null) == $cardHolder->card_holder_id) {
            $cardHolder->update([
                'status'  => $result['records'][0]['status'],
                'payload' => $result['records'][0],
            ]);
            return;
        }
        throw new \Exception('Card holder not found');
    }
}
