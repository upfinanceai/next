<?php

namespace Modules\Deposit\Transactions;

use Modules\Transaction\Abstracts\BusinessTransaction;
use Modules\Transaction\Models\Transaction;

class SavoCryptoDepositTransaction implements BusinessTransaction
{

    public function create($data = null): Transaction
    {
        // TODO: Implement create() method.
    }

    public function clear(Transaction $transaction): Transaction
    {
        // TODO: Implement clear() method.
    }
}
