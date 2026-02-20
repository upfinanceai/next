<?php

namespace App\Modules\Withdraw\Actions;

use App\Modules\Ledger\Actions\CreateTransaction;
use App\Modules\Ledger\Data\TransactionData;
use Exception;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Actions\GetSystemAccount;
use Modules\Account\Actions\GetUserAccount;

class CreateWithdrawByCregisTransaction
{
    use AsAction;

    public function handle($user, $currency, $amount, $chain)
    {
        $user_account = GetUserAccount::run($user, $currency);

        if ($user_account->balance < $amount) {
            throw new Exception('insufficient balance');
        }

        $cregis_account = GetSystemAccount::run(
            owner_id: 'cregis',
            currency: $currency,
            chain: $chain
        );

        if ($cregis_account->balance < $amount) {
            throw new Exception('cregis insufficient balance');
        }

        $transaction = CreateTransaction::run(
            TransactionData::from([
                'type'     => 'withdraw',
                'amount'   => $amount,
                'currency' => $currency,
                'status'   => 'pending',
                'user'     => $user,
                'meta'     => [
                    'provider' => 'cregis',
                    'chain'    => $chain,
                ],
            ])
        );
    }
}
