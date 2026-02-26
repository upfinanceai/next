<?php

namespace Modules\Deposit\Services;

use Exception;
use Modules\Core\Enums\BlockChains;

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
        switch ($currency) {
            case 'USDT':
            case 'USDC':
                return [
                    BlockChains::ETH(),
                    BlockChains::BSC(),
                    BlockChains::TRON(),
                ];
            case 'BNB':
            case 'ETH':
                return [
                    BlockChains::BSC(),
                    BlockChains::ETH(),
                ];
        }
        throw new Exception('Unsupport currency');
    }

    public function getAddress($customer, $currency, $chain)
    {
    }
}
