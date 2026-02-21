<?php

namespace Modules\Transaction\Data;

use Modules\Account\Models\Account;
use Spatie\LaravelData\Data;

class LedgerEntryData extends Data
{
    public function __construct(
        public Account $account,
        public string $amount,
        public string $balance_type = 'available',
        public string $direction = 'credit',
    ) {
    }
}
