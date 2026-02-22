<?php

namespace Modules\Transaction\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Account\Enums\AccountBalanceType;
use Modules\Transaction\Enums\LedgerEntryDirection;

class LedgerEntry extends Model
{
    protected $guarded = [];

    protected $casts = [
        'balance_type' => AccountBalanceType::class,
        'direction'    => LedgerEntryDirection::class,
    ];
}
