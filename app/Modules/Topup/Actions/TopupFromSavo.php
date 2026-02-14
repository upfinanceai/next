<?php

namespace App\Modules\Topup\Actions;

use App\Models\TopupOrder;
use App\Models\Transaction;
use App\Modules\Account\Actions\GetSystemAccount;
use App\Modules\Account\Actions\GetUserAccount;
use App\Modules\Ledger\Actions\ClearTransction;
use App\Modules\Ledger\Actions\CreateLedgerEntry;
use App\Modules\Ledger\Actions\CreateTransaction;
use App\Modules\Ledger\Data\TransactionData;
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

        $system_savo_account = GetSystemAccount::run('savo', $currency);
        $user_account        = GetUserAccount::run($user, $currency);

        DB::beginTransaction();

        $transation = Transaction::where('external_id', $data['txid'])->first();

        if (empty($transation)) {
            $transation = CreateTransaction::run(
                TransactionData::from([
                    'number'      => uniqid(),
                    'type'        => 'topup',
                    'amount'      => $amount,
                    'currency'    => $currency,
                    'user'        => $user,
                    'external_id' => $data['txid'],
                ])
            );
        }

        if ($transation->status === 'cleared') {
            throw new Exception('Transaction already cleared');
        }

        $topup = TopupOrder::firstOrCreate([
            'external_id' => $data['txid'],
            'provider'    => 'savo',
        ], [
            'transaction_id' => $transation->id,
            'user_id'        => $user->id,
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
                ClearTransction::run($transation);
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
