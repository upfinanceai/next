<?php

namespace Modules\Transaction\Abstracts;

use Modules\Transaction\Models\Transaction;

interface BusinessTransaction
{
    public function create($data = null): Transaction;

    public function clear(Transaction $transaction): Transaction;
}
