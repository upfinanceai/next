<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Enums\CurrencyType;
use Modules\Core\Models\Currency;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        Currency::create([
            'code' => 'USD',
            'name'              => 'US Dolloar',
            'symbol'            => '$',
            'type' => CurrencyType::FIAT(),
            'is_base'           => true,
            'rate'              => 1,
            'can_withdraw'      => true,
            'can_deposit'       => false,
            'can_exchange_from' => true,
            'can_exchange_to'   => true,
        ]);
        Currency::create([
            'code'              => 'USDT',
            'name'              => 'USDT',
            'symbol'            => 'USDT',
            'type'              => CurrencyType::CRYPTO(),
            'is_base'           => false,
            'rate'              => 1,
            'can_withdraw'      => true,
            'can_deposit'       => true,
            'can_exchange_from' => true,
            'can_exchange_to'   => true,
        ]);
        Currency::create([
            'code'   => 'USDC',
            'name'   => 'USD Coin',
            'symbol' => 'USDC',
            'type'   => CurrencyType::CRYPTO(),
            'is_base'           => false,
            'rate'              => 1,
            'can_withdraw'      => true,
            'can_deposit'       => true,
            'can_exchange_from' => true,
            'can_exchange_to'   => true,
        ]);
        Currency::create([
            'code'              => 'BTC',
            'name'              => 'Bit Coin',
            'symbol'            => 'BTC',
            'type'              => CurrencyType::CRYPTO(),
            'is_base'           => false,
            'rate'              => 20000,
            'can_withdraw'      => true,
            'can_deposit'       => true,
            'can_exchange_from' => false,
            'can_exchange_to'   => false,
        ]);
        Currency::create([
            'code'   => 'USDT-BEP20',
            'name'              => 'USDT BSC',
            'symbol' => 'USDT',
            'chain'             => 'bsc',
            'type'   => CurrencyType::CRYPTO(),
            'is_base'           => false,
            'rate'              => 1,
            'can_withdraw'      => true,
            'can_deposit'       => true,
            'can_exchange_from' => true,
            'can_exchange_to'   => true,
        ]);
        Currency::create([
            'code'              => 'KWR',
            'name'              => 'South Korean Won',
            'symbol'            => '₩',
            'type'              => CurrencyType::FIAT(),
            'rate'              => 1,
            'can_withdraw'      => true,
            'can_deposit'       => false,
            'can_exchange_from' => false,
            'can_exchange_to'   => false,
        ]);
        Currency::create([
            'code'              => 'JPY',
            'name'              => 'Japanese Yen',
            'symbol'            => '¥',
            'type'              => CurrencyType::FIAT(),
            'rate'              => 155.84,
            'can_withdraw'      => true,
            'can_deposit'       => false,
            'can_exchange_from' => false,
            'can_exchange_to'   => false,
        ]);
    }
}
