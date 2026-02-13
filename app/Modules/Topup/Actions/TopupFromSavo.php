<?php

namespace App\Modules\Topup\Actions;

use App\Models\TopupOrder;
use App\Models\Transaction;
use App\Modules\Account\Actions\GetSystemAccount;
use App\Modules\Account\Actions\GetUserAccount;
use App\Modules\Ledger\Actions\CreateLedgerEntry;
use Exception;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class TopupFromSavo
{
    use AsAction;

    public function handle($user, $data)
    {
        $currency = $data['currency'];
        $amount   = $data['amount'];
        DB::beginTransaction();
        $transation = Transaction::firstOrCreate([
            'external_id' => $data['txid'],
        ], [
            'number'   => uniqid(),
            'type'     => 'topup',
            'amount'   => $amount,
            'currency' => $currency,
            'user_id' => $user->id,
        ]);

        if ($transation->status === 'cleared') {
            throw new Exception('Transaction already cleared');
        }

        $topup = TopupOrder::firstOrCreate([
            'external_id' => $data['txid'],
            'provider'    => 'savo',
        ], [
            'user_id' => $user->id,
            'amount'   => $amount,
            'currency' => $currency,
        ]);

        switch ($data['status']) {
            case 'pending':
                $transation->update([
                    'status' => 'pending',
                ]);
                $topup->update([
                    'status' => 'pending',
                ]);
                break;
            case 'cleared':
                $system_account      = GetSystemAccount::run('cash', $currency);
                $system_savo_account = GetSystemAccount::run('savo', $currency);
                $user_account        = GetUserAccount::run($user, $currency);
                CreateLedgerEntry::run(
                    account: $system_savo_account,
                    amount: $amount,
                    type: 'topup'
                );
                CreateLedgerEntry::run(
                    account: $user_account,
                    amount: $amount,
                    type: 'topup'
                );
                CreateLedgerEntry::run(
                    account: $system_account,
                    amount: $amount,
                    direction: 'debit',
                    type: 'topup'
                );
                $transation->update([
                    'status'     => 'cleared',
                    'cleared_at' => now(),
                ]);
                $topup->update([
                    'status' => 'cleared',
                ]);
                break;
            default:
                $transation->update([
                    'status' => 'suspend',
                ]);
                $topup->update([
                    'status' => $data['status'],
                ]);
        }

        DB::commit();
    }
}
