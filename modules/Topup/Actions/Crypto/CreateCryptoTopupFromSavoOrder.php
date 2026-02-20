<?php

namespace Modules\Topup\Actions\Crypto;

use Exception;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Actions\GetCustomerAccount;
use Modules\Account\Actions\GetSystemAccount;
use Modules\Topup\Models\TopupOrder;
use Modules\Transaction\Actions\ClearTransction;
use Modules\Transaction\Actions\CreateLedgerEntry;
use Modules\Transaction\Actions\CreateTransaction;
use Modules\Transaction\Data\TransactionData;
use Modules\Transaction\Models\Transaction;

class CreateCryptoTopupFromSavoOrder
{
    use AsAction;

    public function handle($customer, $data)
    {
        $currency = $data['currency'];
        $amount   = $data['amount'];

        $system_savo_account = GetSystemAccount::run('savo', $currency);
        $customer_account = GetCustomerAccount::run($customer, $currency);

        DB::beginTransaction();

        $transation = Transaction::where('external_id', $data['txid'])->first();

        if (empty($transation)) {
            $transation = CreateTransaction::run(
                TransactionData::from([
                    'number'      => uniqid(),
                    'type'        => 'topup',
                    'sub_type' => 'savo_crypto',
                    'amount'      => $amount,
                    'currency'    => $currency,
                    'customer' => $customer,
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
            'customer_id' => $customer->id,
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
                    type: 'topup',
                    transaction: $transation
                );
                CreateLedgerEntry::run(
                    account: $customer_account,
                    amount: $amount,
                    type: 'topup',
                    transaction: $transation
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
