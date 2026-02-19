<?php

namespace App\Modules\Transaction\Actions;

use App\Models\Account;
use App\Models\LedgerEntry;
use App\Modules\Asset\Actions\UpdateAccountBalance;
use Lorisleiva\Actions\Concerns\AsAction;

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
        $entry = LedgerEntry::create([
            'type'           => $type,
            'direction'      => $direction === 'credit' ? 'credit' : 'debit',
            'account_id'     => $account->id,
            'currency'       => $account->currency,
            'amount'         => $amount,
            'balance_type'   => $balance_type === 'available' ? 'available' : 'frozen',
            'transaction_id' => $transaction?->id,
        ]);

        UpdateAccountBalance::dispatch($account);

        return $entry;
    }
}
