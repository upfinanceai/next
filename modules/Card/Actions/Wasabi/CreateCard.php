<?php

namespace Modules\Card\Actions\Wasabi;

use Exception;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Card\Adapters\WasabiAdapter;
use Modules\Card\Data\Wasabi\WasabiB2BCardHolderData;
use Modules\Card\Data\Wasabi\WasabiB2CCardHolderData;
use Modules\Card\Models\CardDesign;
use Modules\Card\Models\WasabiCardHolder;
use Modules\Customer\Models\Customer;

class CreateCard
{
    use AsAction;

    public function handle(Customer $customer, CardDesign $cardDesign, $request = [])
    {
        $cardHolder = WasabiCardHolder::where('card_type_id', $cardDesign->external_id)->first();

        if (empty($cardHolder)) {
            if ($cardDesign->model == 'B2B') {
                $data = WasabiB2BCardHolderData::from([
                    'merchantOrderNo' => Str::random(20),
                    'birthday'        => $customer->birthday,
                    'cardTypeId'      => $cardDesign->external_id,
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
            $cardHolder = CreateCardHolder::run($customer, $data);
        }

        if (empty($cardHolder)) {
            throw new Exception('Card holder not found');
        }

        $provider = new WasabiAdapter();

        $card = \Modules\Card\Actions\CreateCard::run($customer, [
            'merchantOrderNo' => Str::random(20),
            'holderId'        => $cardHolder->card_holder_id,
            'cardTypeId'      => $cardDesign->external_id,
            'amount'          => $request['amount'] ?? 0,
        ], $provider);

        $card->update([
            'card_design_id' => $cardDesign->id,
            'customer_id'    => $customer->id,
            'otp_email'      => $cardHolder->email,
        ]);
    }
}
