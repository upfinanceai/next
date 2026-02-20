<?php

namespace Modules\Card\Actions;

use App\Modules\Ledger\Actions\CreateLedgerEntryPair;
use App\Modules\Ledger\Actions\CreateTransaction;
use App\Modules\Ledger\Data\TransactionData;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Actions\GetCardAccount;
use Modules\Account\Actions\GetUserAccount;
use Modules\Card\Models\Card;

class TopupCard
{
    use AsAction;

    public function handle(Card $card, $amount)
    {
        $transaction  = CreateTransaction::run(
            TransactionData::from([
                'type'    => 'topup_card',
                'status'  => 'cleared',
                'user_id' => $card->user_id,
                'amount'  => $amount,
            ])
        );
        $cash_account = GetUserAccount::run($card->user, $card->currency);
        $card_account = GetCardAccount::run($card);

        CreateLedgerEntryPair::run(
            debit_account: $cash_account,
            credit_account: $card_account,
            debit_amount: $amount,
            credit_amount: $amount,
            type: 'topup_card',
            transaction: $transaction
        );
    }
}
