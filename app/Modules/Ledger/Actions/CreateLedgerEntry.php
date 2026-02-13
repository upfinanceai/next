<?php


namespace App\Modules\Ledger\Actions;

use App\Models\LedgerEntry;
use App\Modules\Account\Actions\UpdateAccountBalance;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateLedgerEntry
{
    use AsAction;

    public static function handle(
        $account,
        $direction,
        $amount,
        $balance_type = 'available',
        $transaction = null,
        $type = null,
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
