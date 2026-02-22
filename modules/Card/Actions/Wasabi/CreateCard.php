<?php

namespace Modules\Card\Actions\Wasabi;

use Exception;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Card\Adapters\WasabiAdapter;
use Modules\Card\Data\Wasabi\WasabiB2BCardHolderData;
use Modules\Card\Data\Wasabi\WasabiB2CCardHolderData;
use Modules\Card\Models\CardHolder;
use Modules\Card\Models\CardType;
use Modules\Customer\Models\Customer;

class CreateCard
{
    use AsAction;

    public function handle(Customer $customer, CardType $cardType, $request = [])
    {
        $cardHolder = CardHolder::where('card_type_id', $cardType->id)
            ->where('customer_id', $customer->id)
            ->first();

        if (empty($cardHolder)) {
            if ($cardType->model == 'B2B') {
                $data = WasabiB2BCardHolderData::from([
                    'merchantOrderNo' => Str::random(20),
                    'birthday'        => $customer->birthday,
                    'cardTypeId'      => $cardType->external_id,
                    'postCode'        => $customer->post_code ?? '123456',
                    'mobile'          => $customer->mobile,
                    'email'           => $customer->email,
                    'lastName'        => $customer->last_name,
                    'firstName'       => $customer->first_name,
                    'areaCode'        => $customer->mobile_prefix,
                    'gender'          => $customer->gender,
                    'address'         => $customer->address ?? '123 Loring street',
                    'nationality'     => $customer->nationality ?? 'CN',
                    'country'         => $customer->country ?? 'CN',
                    'town'            => $customer->town ?? 'CN_13_1',
                ]);
            } else {
                $data = WasabiB2CCardHolderData::from([]);
            }
            $cardHolder = CreateCardHolder::run($customer, $cardType, $data);
        }

        if (empty($cardHolder)) {
            throw new Exception('Card holder not found');
        }

        $provider = new WasabiAdapter();

        $card = \Modules\Card\Actions\CreateCard::run($customer, [
            'merchantOrderNo' => Str::random(20),
            'holderId' => $cardHolder->external_id,
            'cardTypeId'      => $cardType->external_id,
            'amount'          => $request['amount'] ?? 0,
        ], $provider);

        $card->update([
            'card_type_id'   => $cardType->id,
            'card_holder_id' => $cardHolder->id,
            'customer_id'    => $customer->id,
            'otp_email'      => $cardHolder->email,
        ]);
    }
}
