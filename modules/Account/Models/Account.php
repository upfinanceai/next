<?php

namespace Modules\Account\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Enums\BlockChains;

class Account extends Model
{
    protected $guarded = [];

    protected $casts = [
        'chain' => BlockChains::class . ':nullable',
    ];
}
