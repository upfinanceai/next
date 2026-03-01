<?php

namespace Modules\Account\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Data\AccountData;
use Modules\Account\Models\Account;

class QueryAccount
{
    use AsAction;

    public function handle(AccountData $data, $firstOnly = true, $create = true)
    {
        $where = [];

        if ($data->number) {
            $where['number'] = $data->number;
            $account         = Account::firstWhere($where);

            if ($account) {
                return $account;
            }
        }

        if ($data->owner_type) {
            $where['owner_type'] = $data->owner_type;
        }

        if ($data->owner_id) {
            $where['owner_id'] = $data->owner_id;
        }

        if ($data->currency) {
            $where['owner_type'] = $data->currency;
        }

        if ($data->chain) {
            $where['chain'] = $data->chain;
        }

        if ($data->category) {
            $where['category'] = $data->category;
        }

        if ($data->purpose) {
            $where['purpose'] = $data->purpose;
        }

        if ($firstOnly) {
            $account = Account::where($where)->first();
            if (!$account && $create) {
                $account = CreateAccount::run($data);
            }
        } else {
            $account = Account::where($where)->get();
        }

        return $account;
    }
}
