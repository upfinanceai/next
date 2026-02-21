<?php

namespace Modules\Transaction\Actions;

use Exception;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Transaction\Enums\TransactionStatus;

class ClearTransction
{
    use AsAction;

    public function handle($transaction, $entries = [])
    {
        if ($transaction->status->equals(TransactionStatus::cleared())) {
            throw new Exception('Transaction already cleared');
        }

        DB::beginTransaction();
        if (!empty($entries)) {
            foreach ($entries as $ledger_entry) {
                CreateLedgerEntry::run(
                    account: $ledger_entry->account,
                    amount: $ledger_entry->amount,
                    balance_type: $ledger_entry->balance_type,
                    transaction: $transaction
                );
            }
        }
        $transaction->status = TransactionStatus::cleared();
        $transaction->cleared_at = now();
        $transaction->save();
        DB::commit();
    }
}
