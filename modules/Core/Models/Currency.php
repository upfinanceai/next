<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Database\factories\CurrencyFactory;
use Modules\Core\Enums\BlockChains;
use Modules\Core\Enums\CurrencyType;
use Modules\Core\Models\Concerns\Activable;
use Modules\Core\Models\Concerns\Metable;

class Currency extends Model
{
    use Activable;
    use Metable;
    use HasFactory;

    protected $casts = [
        'type'  => CurrencyType::class,
        'chain' => BlockChains::class . ':nullable',
    ];

    protected static function newFactory()
    {
        return CurrencyFactory::new();
    }
}
