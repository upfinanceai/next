<?php

namespace Modules\Deposit\Actions\Crypto;

use Exception;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Actions\GetCustomerAccount;
use Modules\Account\Actions\GetSystemAccount;
use Modules\Account\Enums\AccountBalanceType;
use Modules\Deposit\Models\Deposit;
use Modules\Transaction\Actions\ClearTransction;
use Modules\Transaction\Actions\CreateTransaction;
use Modules\Transaction\Data\LedgerEntryData;
use Modules\Transaction\Data\TransactionData;
use Modules\Transaction\Enums\LedgerEntryDirection;
use Modules\Transaction\Models\Transaction;

class CreateCryptoDepositFromSavo
{
    use AsAction;

    public function handle($customer, $data)
    {
        $currency = $data['currency'];
        $amount   = $data['amount'];

        $system_savo_account = GetSystemAccount::run('savo', $currency);
        $customer_account = GetCustomerAccount::run($customer, $currency);

        $deposit = Deposit::firstOrCreate([
            'external_id' => $data['txid'],
            'provider'    => 'savo',
        ], [
            'customer_id' => $customer->id,
            'amount'      => $amount,
            'currency'    => $currency,
            'number'      => snowflake_id(),
            'payload' => $data,
        ]);

        $transation = Transaction::where('external_id', $data['txid'])->first();

        if (empty($transation)) {
            $transation = CreateTransaction::run(
                TransactionData::from([
                    'customer' => $customer,
                    'account'  => $customer_account,
                    'type'     => 'crypto',
                    'sub_type' => 'deposit',
                    'amount'   => $amount,
                    'currency' => $currency,
                    'provider' => 'savo',
                    'external_id' => $data['txid'],
                    'request'  => $data,
                ])
            );
        }

        if ($transation->status === 'cleared') {
            throw new Exception('Transaction already cleared');
        }

        $deposit->update([
            'transaction_id' => $transation->id,
        ]);

        switch ($data['status']) {
            case 'pending':
                $transation->update([
                    'status' => 'pending',
                ]);
                $deposit->update([
                    'status' => 'pending',
                ]);
                break;
            case 'cleared':
                ClearTransction::run($transation, [
                    LedgerEntryData::from([
                        "account" => $system_savo_account,
                        "balance_type" => AccountBalanceType::AVAILABLE(),
                        "direction"    => LedgerEntryDirection::DEBIT(),
                        "amount"  => $amount,
                    ]),
                    LedgerEntryData::from([
                        "account" => $customer_account,
                        "balance_type" => AccountBalanceType::AVAILABLE(),
                        "direction"    => LedgerEntryDirection::CREDIT(),
                        "amount"  => $amount,
                    ]),
                ]);
                $deposit->update([
                    'status' => 'cleared',
                ]);
                break;
            default:
                $transation->update([
                    'status' => 'suspend',
                ]);
                $deposit->update([
                    'status' => $data['status'],
                ]);
        }
    }
}
