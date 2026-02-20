<?php

namespace App\Modules\Asset\Actions;

use App\Modules\Ledger\Actions\ClearTransction;
use App\Modules\Ledger\Actions\CreateLedgerEntry;
use App\Modules\Ledger\Actions\CreateTransaction;
use App\Modules\Ledger\Data\TransactionData;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Actions\GetSystemAccount;
use Modules\Account\Actions\GetUserAccount;

class CreateExchangeTransaction
{
    use AsAction;

    public function handle(
        $user,
        $from_currency,
        $to_currency,
        $from_amount,
        $to_amount,
        $exchange_rate,
    )
    {
        DB::beginTransaction();
        $transaction    = CreateTransaction::run(
            TransactionData::from([
                'user'          => $user,
                'from_currency' => $from_currency,
                'to_currency'   => $to_currency,
                'from_amount'   => $from_amount,
                'to_amount'     => $from_amount,
                'exchange_rate' => $exchange_rate,
                'type'          => 'exchange',
            ])
        );
        $from_account   = GetUserAccount::run($user, $from_currency);
        $to_account     = GetUserAccount::run($user, $to_currency);
        $income_account = GetSystemAccount::run('income', 'USD');

        CreateLedgerEntry::run(
            account: $from_account,
            amount: $from_amount,
            direction: 'debit',
            type: 'exchange_out',
            transaction: $transaction
        );
        CreateLedgerEntry::run(
            account: $to_account,
            amount: $to_amount,
            type: 'exchange_in',
            transaction: $transaction
        );
        $income = $from_amount - $to_amount;
        CreateLedgerEntry::run(
            account: $income_account,
            amount: $income,
            type: 'exchange_income',
            transaction: $transaction
        );
        ClearTransction::run($transaction, ['income' => $income]);
        DB::commit();
    }
}
