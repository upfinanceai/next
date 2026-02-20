<?php

namespace Modules\Transaction\Data;

use Modules\Account\Models\Account;
use Modules\Customer\Models\Customer;
use Spatie\LaravelData\Data;

class TransactionData extends Data
{
    public function __construct(
        public ?string $type,
        public ?string $sub_type,
        public ?Customer $customer,
        public ?float $amount,
        public ?string $currency,
        public ?string $number,
        public ?string $status,
        public ?string $external_id,
        public ?string $from_currency,
        public ?string $to_currency,
        public ?Account $from_account,
        public ?Account $to_account,
        public ?float $from_amount,
        public ?float $to_amount,
        public ?float $exchange_rate,
        public ?array $meta,
    ) {
    }
}
