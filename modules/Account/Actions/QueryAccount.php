<?php

namespace Modules\Account\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Data\AccountData;
use Modules\Account\Models\Account;

class QueryAccount
{
    use AsAction;

    public function handle(AccountData $q, $firstOnly = true, $create = true): Account
    {
        $where = [];

        if ($q->number) {
            $where['number'] = $q->number;
            $account         = Account::firstWhere($where);

            if ($account) {
                return $account;
            }
        }

        if ($q->owner_type) {
            $where['owner_type'] = $q->owner_type;
        }

        if ($q->owner_id) {
            $where['owner_id'] = $q->owner_id;
        }

        if ($q->currency) {
            $where['owner_type'] = $q->currency;
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

        if ($firstOnly) {
            $account = Account::where($where)->first();
            if (!$account && $create) {
                $account = CreateAccount::run($q);
            }
        } else {
            $account = Account::where($where)->get();
        }

        return $account;
    }
}
