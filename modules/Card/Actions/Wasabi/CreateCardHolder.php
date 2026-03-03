<?php

namespace Modules\Card\Actions\Wasabi;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Card\Data\Wasabi\WasabiB2BCardHolderData;
use Modules\Card\Data\Wasabi\WasabiB2CCardHolderData;
use Modules\Card\Models\CardHolder;
use Modules\Card\Models\CardType;
use Modules\Core\Library\WasabiCardApiClient;

class CreateCardHolder
{
    use AsAction;

    public function handle($customer, CardType $cardType, WasabiB2BCardHolderData|WasabiB2CCardHolderData $data)
    {
        $wasabiApiClient = WasabiCardApiClient::make();
        $result          = $wasabiApiClient->createCardHolder($data);

        $cardHolder = CardHolder::create([
            'customer_id'    => $customer->id,
            'card_type_id' => $cardType->id,
            'request'        => $data->toArray(),
            'email'          => $data->email,
            'mobile_prefix'  => $data->areaCode,
            'mobile'         => $data->mobile,
            'model'          => $data->cardHolderModel,
            'status'       => $result['status'],
            'external_id'  => $result['holderId'],
        ]);

        return $cardHolder;
    }
}
