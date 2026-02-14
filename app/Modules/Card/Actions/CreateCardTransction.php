<?php

namespace App\Modules\Card\Actions;

use App\Models\Card;
use App\Modules\Account\Actions\GetCardAccount;
use App\Modules\Account\Actions\GetSystemAccount;
use App\Modules\Ledger\Actions\CreateLedgerEntry;
use App\Modules\Ledger\Actions\CreateTransaction;
use App\Modules\Ledger\Data\TransactionData;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateCardTransction
{
    use AsAction;

    public function handle(Card $card, $amount, $detail = [])
    {
        $transaction  = CreateTransaction::run(
            TransactionData::from([
                'type'   => 'card',
                'amount' => $amount,
                'meta'   => $detail,
            ])
        );
        $card_account = GetCardAccount::run($card);
        $save_account = GetSystemAccount::run('savo', $card->currency);
        CreateLedgerEntry::run(
            account: $card_account,
            amount: $amount,
            direction: 'debit',
            type: 'card',
            transaction: $transaction
        );
        CreateLedgerEntry::run(
            account: $save_account,
            amount: $amount,
            direction: 'debit',
            type: 'card',
            transaction: $transaction
        );
    }
}
