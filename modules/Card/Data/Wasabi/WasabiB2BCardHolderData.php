<?php


namespace Modules\Card\Data\Wasabi;

use Spatie\LaravelData\Data;

class WasabiB2BCardHolderData extends Data
{
    public function __construct(
        public ?string $merchantOrderNo,
        public ?string $cardTypeId,
        public ?string $areaCode,
        public ?string $mobile,
        public ?string $email,
        public ?string $firstName,
        public ?string $lastName,
        public ?string $birthday,
        public ?string $country,
        public ?string $town,
        public ?string $address,
        public ?string $postCode,
        public string $cardHolderModel = 'B2B',
    ) {
    }
}
