<?php

namespace App\Managers;

use App\Modules\Topup\Adapters\SavoTopupAdapter;

class WithdrawManager
{

    public function getAdapter($data)
    {
        return new SavoTopupAdapter();
    }
}
