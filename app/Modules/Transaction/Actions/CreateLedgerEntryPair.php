<?php

namespace App\Modules\Transaction\Actions;

use DB;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateLedgerEntryPair
{
    use AsAction;

    public function handle(
        $debit_account,
        $credit_account,
        $debit_amount,
        $credit_amount,
        $type,
        $transaction = null,
    ) {
        DB::beginTransaction();
        CreateLedgerEntry::run(
            account: $debit_account,
            amount: $debit_amount,
            direction: 'debit',
            type: $type,
            transaction: $transaction,
        );
        CreateLedgerEntry::run(
            account: $credit_account,
            amount: $credit_amount,
            direction: 'credit',
            type: $type,
            transaction: $transaction,
        );
        DB::commit();
    }
}
