<?php

namespace Modules\Exchange\Data;

use Modules\Account\Models\Account;
use Modules\Customer\Models\Customer;
use Spatie\LaravelData\Data;

class ExchangeData extends Data
{
    public function __construct(
        public ?Customer $customer,
        public ?Account $from_account,
        public ?Account $to_account,
        public ?float $from_amount,
        public ?float $to_amount,
        public ?float $rate,
        public ?string $fx_income_currency,
        public ?float $fx_income_amount,
    ) {
    }
}
