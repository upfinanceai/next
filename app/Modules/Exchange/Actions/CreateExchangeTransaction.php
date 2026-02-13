<?php

namespace App\Modules\Exchange\Actions;

use App\Models\LedgerEntry;
use App\Models\Transaction;
use App\Modules\Account\Actions\GetCashAccount;
use DB;

class CreateExchangeTransaction
{

    public static function handle(
        $user,
        $from_currency,
        $to_currency,
        $from_amount,
        $to_amount,
        $exchange_rate,
    )
    {
        DB::beginTransaction();

        $transaction = Transaction::create([
            'type'    => 'exchange',
            'status'  => 'cleared',
            'user_id' => $user->id,
            'from_currency' => $from_currency,
            'to_currency'   => $to_currency,
            'from_amount'   => $from_amount,
            'to_amount'     => $to_amount,
            'exchange_rate' => $exchange_rate,
        ]);
        $from_account = GetCashAccount::handle($user, $from_currency);
        $to_account = GetCashAccount::handle($user, $to_currency);

        LedgerEntry::create([
            'type'           => 'exchange_from',
            'account_id'     => $from_account->id,
            'transaction_id' => $transaction->id,
            'amount'         => $from_amount,
            'direction'      => 'debit',
        ]);

        LedgerEntry::create([
            'type'           => 'exchange_to',
            'account_id'     => $to_account->id,
            'transaction_id' => $transaction->id,
            'amount'         => $to_amount,
            'direction'      => 'credit',
        ]);

        DB::commit();
    }
}
