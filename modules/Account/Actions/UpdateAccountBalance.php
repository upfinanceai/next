<?php

namespace Modules\Account\Actions;

use DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Enums\AccountBalanceType;
use Modules\Account\Models\Account;
use Modules\Transaction\Models\LedgerEntry;

class UpdateAccountBalance
{
    use AsAction;

    /**
     * Recalculate balances from ledger_entries (repair/reconcile purpose).
     * Safe under concurrency via row lock + transaction.
     */
    public function handle(Account $account): Account
    {
        return DB::transaction(function () use ($account) {
            // 1) Lock the account row to avoid concurrent writers overwriting balances
            /** @var Account $locked */
            $locked = Account::query()
                ->whereKey($account->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            // 2) Single query to fetch sums for both balance types
            $rows = LedgerEntry::query()
                ->where('account_id', $locked->id)
                ->whereIn('balance_type', AccountBalanceType::toValues())
                ->groupBy('balance_type')
                ->selectRaw("
                    balance_type,
                    COALESCE(SUM(CASE WHEN direction = 'CREDIT' THEN amount ELSE 0 END), 0) AS credit,
                    COALESCE(SUM(CASE WHEN direction = 'DEBIT'  THEN amount ELSE 0 END), 0) AS debit
                ")
                ->get()
                ->keyBy('balance_type');

            $availableCredit = (string)($rows[AccountBalanceType::AVAILABLE()->value]->credit ?? '0');
            $availableDebit  = (string)($rows[AccountBalanceType::AVAILABLE()->value]->debit ?? '0');
            $frozenCredit    = (string)($rows[AccountBalanceType::FROZEN()->value]->credit ?? '0');
            $frozenDebit     = (string)($rows[AccountBalanceType::FROZEN()->value]->debit ?? '0');

            $isAsset = $locked->is_asset;

            // 3) Compute balances (ASSET: debit-credit, others: credit-debit)
            if ($isAsset) {
                $locked->balance        = bcsub($availableDebit, $availableCredit, 8);
                $locked->frozen_balance = bcsub($frozenDebit, $frozenCredit, 8);
            } else {
                $locked->balance        = bcsub($availableCredit, $availableDebit, 8);
                $locked->frozen_balance = bcsub($frozenCredit, $frozenDebit, 8);
            }

            $locked->total_balance = bcadd((string)$locked->balance, (string)$locked->frozen_balance, 8);

            $locked->save();

            return $locked;
        });
    }

    public function asJob($account)
    {
        $this->handle($account);
    }
}
