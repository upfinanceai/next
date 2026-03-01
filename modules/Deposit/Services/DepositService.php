<?php

namespace Modules\Deposit\Services;

use DB;
use Modules\Core\Abstracts\Service;
use Modules\Core\Enums\CurrencyType;
use Modules\Core\Models\Currency;
use Modules\Customer\Models\Customer;
use Modules\Deposit\Enums\DepositMethods;
use Modules\Deposit\Models\Deposit;
use Modules\Transaction\Actions\CreateTransaction;
use Modules\Transaction\Data\TransactionData;
use Modules\Transaction\Enums\LedgerEntryDirection;
use Modules\Transaction\Enums\TransactionStatus;
use Modules\Transaction\Enums\TransactionType;

class DepositService extends Service
{
    public function getMethods($currency, ?Customer $customer = null): array
    {
        $methods = [];

        $currency_model = Currency::where(['code' => $currency])->firstOrFail();

        if ($currency_model->type->equals(CurrencyType::CRYPTO())) {
            if ($currency_model->can_deposit) {
                $methods[] = DepositMethods::CRYPTO_DEPOSIT();
            }
        }

        return $methods;
    }

    public function create($payload)
    {
        // create deposit record
        $deposit = Deposit::firstOrCreate([
            'provider'    => $payload['provider'],
            'external_id' => $payload['external_id'],
        ],
            [
                'status'          => 'pending',
                'number'          => snowflake_id(),
                'customer_id'     => $payload['customer_id'],
                'amount'          => $payload['amount'],
                'currency'        => $payload['currency'],
                'request_payload' => $payload,
            ]);

        // get rules
        // auto approve
        $this->approve($deposit);
    }

    public function approve($deposit)
    {
        $deposit->update([
            'status' => 'approved',
        ]);
        $this->post($deposit);
    }

    public function reject($deposit)
    {
        $deposit->update([
            'status' => 'rejected',
        ]);
    }

    public function post(Deposit $deposit)
    {
        DB::beginTransaction();
        $deposit->update([
            'status' => 'posted',
        ]);
        $customer         = $deposit->customer;
        $customer_account = app('account')->getCustomerCashAccount($customer, $deposit->currency);
        $trust_account = app('account')->getSystemTrustAccount(owner_id: 'savo', currency: $deposit->currency);

        $transaction   = CreateTransaction::run(
            TransactionData::from([
                'status'   => TransactionStatus::PENDING(),
                'type'     => TransactionType::DEPOSIT(),
                'sub_type' => 'CRYPTO_DEPOSIT',
                'currency' => $deposit->currency,
                'amount'   => $deposit->amount,
                'account'  => $customer_account,
            ])
        );
        app('transaction')->post($transaction, [
            [
                'direction' => LedgerEntryDirection::CREDIT(),
                'account'   => $customer_account,
                'amount'    => $deposit->amount,
                'currency'  => $deposit->currency,
            ],
            [
                'direction' => LedgerEntryDirection::DEBIT(),
                'account'   => $trust_account,
                'amount'    => $deposit->amount,
                'currency'  => $deposit->currency,
            ],
        ]);
        DB::commit();
    }
}
