<?php

namespace Modules\Transaction\Services;

use Modules\Core\Abstracts\Service;
use Modules\Transaction\Actions\CreateTransaction;
use Modules\Transaction\Data\TransactionData;

class TransactionService extends Service
{

    public function create(TransactionData $data)
    {
        $transaction = CreateTransaction::run($data);
        return $transaction;
    }

    public function post($entries = [])
    {
        if (empty($this->transaction)) {
        }
    }
}
