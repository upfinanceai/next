<?php

namespace App\Modules\Topup\Contracts;

interface TopupProvider
{
    /**
     * @param $data
     * @return mixed
     */
    public function creatTopupOrder($data);
}
