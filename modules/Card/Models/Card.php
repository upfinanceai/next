<?php

namespace Modules\Card\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Core\Models\BelongsToCustomer;
use Modules\Core\Models\Metable;
use Modules\Customer\Models\Customer;

class Card extends Model
{
    use HasFactory;
    use BelongsToCustomer;
    use Metable;

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
