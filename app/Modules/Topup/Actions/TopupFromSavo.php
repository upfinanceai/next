<?php

namespace App\Modules\Topup\Actions;

use App\Models\Account;
use App\Models\LedgerEntry;
use App\Models\TopupOrder;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\DB;

class TopupFromSavo
{
    public static function handle($data)
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
        ]);

        if ($transation->status === 'cleared') {
            throw new Exception('Transaction already cleared');
        }

        $topup = TopupOrder::firstOrCreate([
            'external_id' => $data['txid'],
            'provider'    => 'savo',
        ], [
            'user_id'  => $data['user_id'],
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
                $system_account      = Account::where([
                    'owner_type' => 'system',
                    'owner_id'   => 'cash',
                    'currency'   => $currency,
                    'type'       => 'available',
                ])->firstOrFail();
                $system_savo_account = Account::where([
                    'owner_type' => 'system',
                    'owner_id'   => 'savo',
                    'currency'   => $currency,
                    'type'       => 'available',
                ])->firstOrFail();
                $user_account        = Account::where([
                    'owner_type' => 'user',
                    'owner_id'   => $data['user_id'],
                    'currency'   => $currency,
                    'type'       => 'available',
                ])->firstOrFail();
                LedgerEntry::create([
                    'transaction_id' => $transation->id,
                    'account_id'     => $system_savo_account->id,
                    'amount'         => $amount,
                    'type'           => 'topup',
                    'direction'      => 'credit',
                ]);
                LedgerEntry::create([
                    'transaction_id' => $transation->id,
                    'account_id'     => $user_account->id,
                    'amount'         => $amount,
                    'type'           => 'topup',
                    'direction'      => 'credit',
                ]);
                LedgerEntry::create([
                    'transaction_id' => $transation->id,
                    'account_id'     => $system_account->id,
                    'amount'         => $amount,
                    'type'           => 'topup',
                    'direction'      => 'debit',
                ]);
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
