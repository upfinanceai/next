<?php

namespace Modules\Account\Actions;

use App\Modules\Ledger\Actions\CreateLedgerEntry;
use Lorisleiva\Actions\Concerns\AsAction;

class FrozeBalance
{
    use AsAction;

    public function handle($account, $amount, $type, $transaction = null)
    {
        CreateLedgerEntry::run(
            account: $account,
            amount: $amount,
            direction: 'debit',
            type: $type,
            transaction: $transaction
        );

        CreateLedgerEntry::run(
            account: $account,
            amount: $amount,
            balance_type: 'frozen',
            type: $type,
            transaction: $transaction
        );
    }
}
