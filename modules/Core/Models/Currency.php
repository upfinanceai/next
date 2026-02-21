<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Database\factories\CurrencyFactory;

class Currency extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CurrencyFactory::new();
    }
}
