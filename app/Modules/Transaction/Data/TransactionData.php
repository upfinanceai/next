<?php

namespace App\Modules\Transaction\Data;

use App\Models\User;
use Spatie\LaravelData\Data;

class TransactionData extends Data
{
    public function __construct(
        public ?string $type,
        public ?User $user,
        public ?float $amount,
        public ?string $currency,
        public ?string $number,
        public ?string $status,
        public ?string $external_id,
        public ?string $from_currency,
        public ?string $to_currency,
        public ?float $from_amount,
        public ?float $to_amount,
        public ?float $exchange_rate,
        public ?array $meta,
    ) {
    }
}
