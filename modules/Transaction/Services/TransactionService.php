<?php

namespace Modules\Transaction\Services;

use DB;
use Modules\Account\Enums\AccountBalanceType;
use Modules\Core\Abstracts\Service;
use Modules\Core\Exceptions\LogicException;
use Modules\Transaction\Actions\CreateLedgerEntry;
use Modules\Transaction\Data\LedgerEntryData;
use Modules\Transaction\Enums\LedgerEntryDirection;
use Modules\Transaction\Models\Transaction;

class TransactionService extends Service
{
    public function post(Transaction $transaction, array $entries = [])
    {
        return DB::transaction(function () use ($transaction, $entries) {
            $totalDebit  = 0;
            $totalCredit = 0;
            foreach ($entries as $entry) {
                CreateLedgerEntry::run(
                    LedgerEntryData::from([
                        "account"      => $entry['account'],
                        "amount"       => $entry['amount'],
                        "direction"    => $entry['direction'],
                        "balance_type" => $entry['balance_type'] ?? AccountBalanceType::AVAILABLE(),
                        "transaction"  => $transaction,
                    ]),
                );

                if ($entry['direction']->equals(LedgerEntryDirection::DEBIT())) {
                    $totalDebit += $entry['amount'];
                } else {
                    $totalCredit += $entry['amount'];
                }
            }
            if (bccomp($totalDebit, $totalCredit, 8) !== 0) {
                throw new LogicException('Ledger not balanced');
            }
            return $transaction;
        });
    }
}
