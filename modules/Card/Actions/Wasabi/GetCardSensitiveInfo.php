<?php


namespace Modules\Card\Actions\Wasabi;

use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Card\Models\Card;
use Modules\Core\Services\WasabiCardApiClient;

class GetCardSensitiveInfo
{
    use AsAction;

    public function handle(Card $card)
    {
        $result = WasabiCardApiClient::make()->getCardInfoSensitive([
            'cardNo' => $card->external_id,
        ]);
        $data   = [
            'card_number' => WasabiCardApiClient::make()->decryptPrivateKey($result['cardNumber']),
            'cvv'         => WasabiCardApiClient::make()->decryptPrivateKey($result['cvv']),
            'expire_date' => WasabiCardApiClient::make()->decryptPrivateKey($result['expireDate']),
        ];
        $card->update([
            'last_no' => Str::substr($data['card_number'], -4),
        ]);
        dump($data);
        return $data;
    }
}
