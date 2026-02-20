<?php

namespace Modules\Transaction\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Actions\UpdateAccountBalance;
use Modules\Account\Models\Account;
use Modules\Transaction\Models\LedgerEntry;

class CreateLedgerEntry
{
    use AsAction;

    public function handle(
        Account $account,
        $amount,
        $direction = 'credit',
        $balance_type = 'available',
        $type = null,
        $transaction = null,
    ) {
        if ($balance_type == 'available') {
            $balance_before = $account->balance ?? 0;
            $balance_after  = $balance_before + ($direction === 'credit' ? $amount : -$amount);
        } else {
            $balance_before = $account->frozen_balance ?? 0;
            $balance_after  = $balance_before + ($direction === 'credit' ? $amount : -$amount);
        }
        $entry = LedgerEntry::create([
            'type'           => $type,
            'direction'      => $direction === 'credit' ? 'credit' : 'debit',
            'account_id'     => $account->id,
            'currency'       => $account->currency,
            'amount'         => $amount,
            'balance_type'   => $balance_type === 'available' ? 'available' : 'frozen',
            'transaction_id' => $transaction?->id,
            'balance_before' => $balance_before,
            'balance_after'  => $balance_after,
            'owner_id'       => $account->owner_id,
        ]);

        UpdateAccountBalance::dispatch($account);

        return $entry;
    }
}
