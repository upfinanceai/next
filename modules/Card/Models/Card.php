<?php

namespace Modules\Card\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Card\Enum\CardStatus;
use Modules\Core\Models\Concerns\BelongsToCustomer;
use Modules\Core\Models\Concerns\Metable;
use Modules\Customer\Models\Customer;

class Card extends Model
{
    use HasFactory;
    use BelongsToCustomer;
    use Metable;

    protected $guarded = [];

    protected $casts = [
        'status' => CardStatus::class,
    ];

    public function card_type(): BelongsTo
    {
        return $this->belongsTo(CardType::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
