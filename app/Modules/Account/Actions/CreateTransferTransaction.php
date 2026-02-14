<?php


namespace App\Modules\Account\Actions;

use App\Modules\Ledger\Actions\CreateLedgerEntryPair;
use App\Modules\Ledger\Actions\CreateTransaction;
use App\Modules\Ledger\Data\TransactionData;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateTransferTransaction
{
    use AsAction;

    public function handle($from_account, $to_account, $from_amount, $to_amount)
    {
        $transaction = CreateTransaction::run(
            TransactionData::from([
                'type'          => 'transfer',
                'from_amount'   => $from_amount,
                'to_amount'     => $to_amount,
                'from_currency' => $from_account->currency,
                'to_currency'   => $to_account->currency,
            ])
        );

        CreateLedgerEntryPair::run(
            debit_account: $from_account,
            credit_account: $to_account,
            debit_amount: $from_amount,
            credit_amount: $to_amount,
            type: 'transfer',
            transaction: $transaction,
        );
    }
}
