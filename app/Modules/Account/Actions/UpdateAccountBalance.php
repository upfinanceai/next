<?php

namespace App\Modules\Account\Actions;

use App\Models\LedgerEntry;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateAccountBalance
{
    use AsAction;

    public function handle($account)
    {
        $total_available = LedgerEntry::where('account_id', $account->id)
            ->where('balance_type', 'available')
            ->selectRaw("
            SUM(CASE WHEN direction = 'credit' THEN amount ELSE 0 END) as credit,
            SUM(CASE WHEN direction = 'debit' THEN amount ELSE 0 END) as debit
        ")->first();

        $total_frozen = LedgerEntry::where('account_id', $account->id)
            ->where('balance_type', 'frozen')
            ->selectRaw("
            SUM(CASE WHEN direction = 'credit' THEN amount ELSE 0 END) as credit,
            SUM(CASE WHEN direction = 'debit' THEN amount ELSE 0 END) as debit
        ")->first();

        $account->balance        = $total_available->credit - $total_available->debit;
        $account->frozen_balance = $total_frozen->credit - $total_frozen->debit;
        $account->save();
    }

    public function asJob($account)
    {
        $this->handle($account);
    }
}
