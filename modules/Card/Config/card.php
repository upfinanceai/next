<?php

use Modules\Card\Adapters\SavoAdapter;
use Modules\Card\Adapters\WasabiAdapter;

return [
    'adapters' => [
        'savo'   => SavoAdapter::class,
        'wasabi' => WasabiAdapter::class,
    ],
];
