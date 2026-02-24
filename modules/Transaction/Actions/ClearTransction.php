<?php

namespace Modules\Transaction\Actions;

use Exception;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Enums\AccountBalanceType;
use Modules\Transaction\Data\LedgerEntryData;
use Modules\Transaction\Enums\TransactionStatus;
use Modules\Transaction\Models\LedgerEntry;

class ClearTransction
{
    use AsAction;

    public function handle($transaction, $entries = [])
    {
        if ($transaction->status->equals(TransactionStatus::cleared())) {
            throw new Exception('Transaction already cleared');
        }

        DB::beginTransaction();
        $lastEntry = LedgerEntry::orderBy('id', 'desc')->lockForUpdate()->first();
        $previousHash = $lastEntry ? $lastEntry->hash : str_repeat('0', 64);
        if (!empty($entries)) {
            foreach ($entries as $ledger_entry) {
                $entry = CreateLedgerEntry::run(
                    LedgerEntryData::from([
                        "account"      => $ledger_entry->account,
                        "amount"       => $ledger_entry->amount,
                        "direction"    => $ledger_entry->direction,
                        "balance_type" => $ledger_entry->balance_type ?? AccountBalanceType::AVAILABLE(),
                        "transaction"  => $transaction,
                    ]),
                    $previousHash
                );
                $previousHash = $entry->hash;
            }
        }
        $transaction->status = TransactionStatus::cleared();
        $transaction->cleared_at = now();
        $transaction->save();
        DB::commit();
    }
}
