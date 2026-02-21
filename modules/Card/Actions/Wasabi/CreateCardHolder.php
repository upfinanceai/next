<?php

namespace Modules\Card\Actions\Wasabi;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Card\Data\Wasabi\WasabiB2BCardHolderData;
use Modules\Card\Data\Wasabi\WasabiB2CCardHolderData;
use Modules\Card\Models\WasabiCardHolder;
use Modules\Core\Services\WasabiCardApiClient;

class CreateCardHolder
{
    use AsAction;

    public function handle($customer, WasabiB2BCardHolderData|WasabiB2CCardHolderData $data)
    {
        $wasabiApiClient = WasabiCardApiClient::make();
        $result          = $wasabiApiClient->createCardHolder($data);

        $cardHolder = WasabiCardHolder::create([
            'customer_id'    => $customer->id,
            'card_holder_id' => $result['holderId'],
            'card_type_id'   => $result['cardTypeId'],
            'status'         => $result['status'],
            'request'        => $data->toArray(),
            'email'          => $data->email,
            'mobile_prefix'  => $data->areaCode,
            'mobile'         => $data->mobile,
            'model'          => $data->cardHolderModel,
        ]);

        return $cardHolder;
    }
}
