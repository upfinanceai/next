<?php

namespace Modules\Topup\Actions\Crypto;

use Exception;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Actions\GetCustomerAccount;
use Modules\Account\Actions\GetSystemAccount;
use Modules\Topup\Models\TopupOrder;
use Modules\Transaction\Actions\ClearTransction;
use Modules\Transaction\Actions\CreateTransaction;
use Modules\Transaction\Data\LedgerEntryData;
use Modules\Transaction\Data\TransactionData;
use Modules\Transaction\Models\Transaction;

class CreateCryptoTopupFromSavo
{
    use AsAction;

    public function handle($customer, $data)
    {
        $currency = $data['currency'];
        $amount   = $data['amount'];

        $system_savo_account = GetSystemAccount::run('savo', $currency);
        $customer_account = GetCustomerAccount::run($customer, $currency);

        $topup = TopupOrder::firstOrCreate([
            'external_id' => $data['txid'],
            'provider'    => 'savo',
        ], [
            'customer_id' => $customer->id,
            'amount'      => $amount,
            'currency'    => $currency,
            'number'      => snowflake_id(),
        ]);

        $transation = Transaction::where('external_id', $data['txid'])->first();

        if (empty($transation)) {
            $transation = CreateTransaction::run(
                TransactionData::from([
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

        $topup->update([
            'transaction_id' => $transation->id,
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
                ClearTransction::run($transation, [
                    LedgerEntryData::from([
                        "account" => $system_savo_account,
                        "amount"  => $amount,
                    ]),
                    LedgerEntryData::from([
                        "account" => $customer_account,
                        "amount"  => $amount,
                    ]),
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
    }
}
