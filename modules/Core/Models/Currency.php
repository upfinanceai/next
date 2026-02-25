<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Database\factories\CurrencyFactory;
use Modules\Core\Enums\BlockChains;
use Modules\Core\Enums\CurrencyType;

class Currency extends Model
{
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
