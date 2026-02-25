<?php

namespace Modules\Withdraw\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Transaction\Models\Transaction;
use Modules\Withdraw\Enums\WithdrawStatus;

class Withdraw extends Model
{
    protected $guarded = [];

    protected $casts = [
        'status'          => WithdrawStatus::class,
        'request_payload' => 'array',
        'requested_at'    => 'datetime',
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
