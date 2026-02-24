<?php

namespace Modules\Core\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Customer\Models\Customer;

/**
 * @mixin Model
 */
trait BelongsToCustomer
{
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeOfCustomer($query, $customer)
    {
        if (is_string($customer)) {
            $customer = Customer::findOrFail($customer);
        }
        return $query->where('customer_id', $customer->id);
    }
}
