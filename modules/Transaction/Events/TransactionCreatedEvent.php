<?php

namespace Modules\Transaction\Events;

use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Transaction\Models\Transaction;

class TransactionCreatedEvent
{
    use Dispatchable;

    public function __construct(
        public Transaction $transaction
    ) {
    }
}
