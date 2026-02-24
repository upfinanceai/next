<?php

namespace Modules\Exchange\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Actions\GetSystemAccount;
use Modules\Exchange\Data\ExchangeData;
use Modules\Exchange\Models\Exchange;
use Modules\Transaction\Actions\ClearTransction;
use Modules\Transaction\Actions\CreateTransaction;
use Modules\Transaction\Data\LedgerEntryData;
use Modules\Transaction\Data\TransactionData;
use Modules\Transaction\Enums\LedgerEntryDirection;
use Modules\Transaction\Enums\TransactionStatus;

class CreateExchangeTransaction
{
    use AsAction;

    public function handle(ExchangeData $data)
    {
        $exchange = Exchange::create([
            'number'             => snowflake_id(),
            'customer_id'        => $data->customer->id,
            'from_account_id'    => $data->from_account->id,
            'to_account_id'      => $data->to_account->id,
            'from_currency'      => $data->from_account->currency,
            'to_currency'        => $data->to_account->currency,
            'from_amount'        => $data->from_amount,
            'to_amount'          => $data->to_amount,
            'rate'               => $data->rate,
            'fx_income_currency' => $data->fx_income_currency,
            'fx_income_amount'   => $data->fx_income_amount,
        ]);

        $transaction           = CreateTransaction::run(
            TransactionData::from([
                'customer'      => $data->customer,
                'type'          => 'exchange',
                'status'        => TransactionStatus::created(),
                'from_amount'   => $data->from_amount,
                'to_amount'     => $data->to_amount,
                'from_account'  => $data->from_account,
                'to_account'    => $data->to_account,
                'exchange_rate' => $data->rate,
            ])
        );
        $system_from_inventory = GetSystemAccount::run(currency: $data->from_account->currency, purpose: 'savo');
        $system_to_inventory   = GetSystemAccount::run(currency: $data->to_account->currency, purpose: 'savo');

        $fx_account = GetSystemAccount::run(currency: $data->fx_income_currency, purpose: 'fx_income');

        ClearTransction::run($transaction, [
            LedgerEntryData::from([
                'account'   => $data->from_account,
                'amount'    => $data->from_amount,
                'direction' => LedgerEntryDirection::DEBIT(),
            ]),
            LedgerEntryData::from([
                'account'   => $system_from_inventory,
                'amount'    => $data->from_amount,
                'direction' => LedgerEntryDirection::CREDIT(),
            ]),
            LedgerEntryData::from([
                'account'   => $data->to_account,
                'amount'    => $data->to_amount,
                'direction' => LedgerEntryDirection::CREDIT(),
            ]),
            LedgerEntryData::from([
                'account'   => $system_to_inventory,
                'amount'    => $data->to_amount,
                'direction' => LedgerEntryDirection::DEBIT(),
            ]),
            LedgerEntryData::from([
                'account'   => $fx_account,
                'amount'    => $data->fx_income_amount,
                'direction' => LedgerEntryDirection::CREDIT(),
            ]),
        ]);
    }
}
