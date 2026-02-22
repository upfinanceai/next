<?php

namespace Modules\Transaction\Data;

use Modules\Account\Enums\AccountBalanceType;
use Modules\Account\Models\Account;
use Modules\Transaction\Enums\LedgerEntryDirection;
use Modules\Transaction\Models\Transaction;
use Spatie\LaravelData\Data;

class LedgerEntryData extends Data
{
    public function __construct(
        public ?Account $account,
        public ?float $amount,
        public ?Transaction $transaction,
        public ?AccountBalanceType $balance_type,
        public ?LedgerEntryDirection $direction,
    ) {
    }
}
