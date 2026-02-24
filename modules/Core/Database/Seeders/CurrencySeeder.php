<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Models\Currency;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        Currency::create([
            'id'                => 'USD',
            'name'              => 'US Dolloar',
            'symbol'            => '$',
            'is_crypto'         => false,
            'is_base'           => true,
            'rate'              => 1,
            'can_withdraw'      => true,
            'can_deposit'       => false,
            'can_exchange_from' => true,
            'can_exchange_to'   => true,
        ]);
        Currency::create([
            'id'                => 'USDT',
            'name'              => 'USDT',
            'symbol'            => '$',
            'is_crypto'         => true,
            'is_base'           => false,
            'rate'              => 1,
            'can_withdraw'      => true,
            'can_deposit'       => true,
            'can_exchange_from' => true,
            'can_exchange_to'   => true,
        ]);
        Currency::create([
            'id'                => 'USDT-BEP20',
            'name'              => 'USDT BSC',
            'symbol'            => '$',
            'chain'             => 'bsc',
            'is_crypto'         => true,
            'is_base'           => false,
            'rate'              => 1,
            'can_withdraw'      => true,
            'can_deposit'       => true,
            'can_exchange_from' => true,
            'can_exchange_to'   => true,
        ]);
    }
}
