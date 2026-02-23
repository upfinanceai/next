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

    public function getCurrentHashAttribute()
    {
        $dataToHash = $this->prev_hash .
            $this->account_id .
            $this->currency .
            ($this->amount + 0) .
            $this->direction->value .
            $this->created_at->format('Y-m-d H:i:s');
        return hash('sha256', $dataToHash);
    }
}
