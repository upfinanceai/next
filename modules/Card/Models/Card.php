<?php

namespace Modules\Card\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Customer\Models\Customer;
use Modules\Support\Models\HasIdPrefix;

class Card extends Model
{
    use HasIdPrefix;
    use HasFactory;

    protected $guarded = [];

    public function cardDesign(): BelongsTo
    {
        return $this->belongsTo(CardDesign::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
