<?php

namespace Modules\Withdraw\Data;

use Modules\Customer\Models\Customer;
use Spatie\LaravelData\Data;

class WithdrawData extends Data
{
    public function __construct(
        public ?Customer $customer,
        public ?string $currency,
        public ?string $chain,
        public ?string $amount,
        public ?array $payload,
    ) {
    }

    public function toArray(): array
    {
        $data             = parent::toArray();
        $data['customer'] = $this->customer->id;
        return $data;
    }
}
