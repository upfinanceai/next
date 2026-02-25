<?php

namespace Modules\Withdraw\Contracts;

use Modules\Withdraw\Models\Withdraw;

interface WithdrawAdapter
{
    public function submit(Withdraw $withdraw);

    public function getName(): string;
}
