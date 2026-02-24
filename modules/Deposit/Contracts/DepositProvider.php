<?php

namespace Modules\Deposit\Contracts;

interface DepositProvider
{
    /**
     * @param $data
     * @return mixed
     */
    public function create($data);
}
