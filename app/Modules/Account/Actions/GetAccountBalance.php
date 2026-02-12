<?php

namespace App\Modules\Account\Actions;

use App\Models\LedgerEntry;

class GetAccountBalance
{
    public static function handle($account)
    {
        $credits = LedgerEntry::where([
            'account_id' => $account->id,
            'direction'  => 'credit',
        ])->sum('amount');
        $debits  = LedgerEntry::where([
            'account_id' => $account->id,
            'direction'  => 'debit',
        ])->sum('amount');
        return $credits - $debits;
    }

}
