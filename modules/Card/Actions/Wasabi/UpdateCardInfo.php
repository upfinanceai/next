<?php


namespace Modules\Card\Actions\Wasabi;

use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Card\Models\Card;
use Modules\Core\Library\WasabiCardApiClient;

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
            'normal'  => 'active',
            'pending' => 'pending',
        ];
        dump($result);
        $card->update([
            'status' => $status_map[Str::lower($result['status'])] ?? 'unkown',
        ]);
    }
}
