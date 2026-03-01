<?php

namespace Modules\Account\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Account\Data\AccountData;

class GetAccounts
{
    use AsAction;

    public function handle(AccountData $data)
    {
        return QueryAccount::run($data, true, false);
    }
}
