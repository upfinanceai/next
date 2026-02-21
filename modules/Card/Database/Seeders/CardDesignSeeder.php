<?php

namespace Modules\Card\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Card\Models\CardDesign;

class CardDesignSeeder extends Seeder
{
    public function run(): void
    {
        CardDesign::create([
            'type'      => 'physical',
            'provider'  => 'wasabi',
            'status'    => 'active',
            'publisher' => 'master_card',
        ]);

        CardDesign::create([
            'type'      => 'physical',
            'provider'  => 'savo',
            'status'    => 'active',
            'publisher' => 'visa',
        ]);

    }
}
