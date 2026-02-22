<?php

namespace Modules\Card\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Actions\GetCustomerAccount;
use Modules\Card\Models\Card;
use Modules\Core\Exceptions\InsufficientBalanceException;

class DepositCard
{
    use AsAction;

    public function handle(Card $card, $amount)
    {
        $cash_account = GetCustomerAccount::run($card->customer, $card->currency);
        if ($cash_account->avaiable_balance < $amount) {
            throw new InsufficientBalanceException();
        }

        $provider = GetCardProvider::run($card);

        // create deposit transaction
        $provider->deposit($card, $amount);
    }
}
