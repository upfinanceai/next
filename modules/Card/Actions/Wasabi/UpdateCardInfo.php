<?php


namespace Modules\Card\Actions\Wasabi;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Card\Models\Card;
use Modules\Core\Services\WasabiCardApiClient;

class UpdateCardInfo
{
    use AsAction;

    public function handle(Card $card)
    {
        $result     = WasabiCardApiClient::make()->getCardInfo([
            'cardNo'         => $card->external_id,
            'onlySimpleInfo' => false,
        ]);
        $status_map = [
            'Normal'  => 'active',
            'Pending' => 'pending',
        ];
        $card->update([
            'status' => $status_map[$result['status']] ?? 'unkown',
        ]);
    }
}
