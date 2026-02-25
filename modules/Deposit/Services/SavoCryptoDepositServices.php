<?php

namespace Modules\Deposit\Services;

class SavoCryptoDepositServices
{
    public function getCurrencies()
    {
        return [
            'USDT',
            'USDC',
        ];
    }

    public function getChains($customer, $currency)
    {
    }

    public function getAddress($customer, $currency, $chain)
    {
    }
}
