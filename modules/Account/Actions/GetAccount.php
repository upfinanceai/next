<?php

namespace Modules\Account\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Data\AccountData;
use Modules\Account\Models\Account;

class GetAccount
{
    use AsAction;

    public function handle(AccountData $q, $create = true): Account
    {
        if ($q->number) {
            $account = Account::firstWhere('number', $q->number);
            if ($account) {
                return $account;
            }
        }

        $where = [
            'owner_type' => $q->owner_type,
            'owner_id'   => $q->owner_id,
            'currency'   => $q->currency,
        ];

        if ($q->number) {
            $where['number'] = $q->number;
        }
        if ($q->chain) {
            $where['chain'] = $q->chain;
        }
        if ($q->category) {
            $where['category'] = $q->category;
        }
        if ($q->purpose) {
            $where['purpose'] = $q->purpose;
        }

        $account = Account::where($where)->first();

        if (!$account && $create) {
            $account = CreateAccount::run($q);
        }

        return $account;
    }
}
