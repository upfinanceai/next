<?php

namespace Modules\Transaction\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\Concerns\Metable;
use Modules\Transaction\Enums\TransactionStatus;

class Transaction extends Model
{
    use Metable;

    protected $guarded = [];

    protected $casts = [
        'status' => TransactionStatus::class,
        'request' => 'array',
    ];
}
