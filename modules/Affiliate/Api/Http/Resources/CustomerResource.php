<?php

namespace Modules\Affiliate\Api\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Customer\Models\Customer;

/**
 * @mixin Customer
 */
class CustomerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name'  => $this->name,
            'email' => $this->email,
        ];
    }
}
