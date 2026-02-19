<?php

namespace Modules\Customer\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasUlids;

    protected $guarded = [];

    protected $casts = [
        'meta' => 'array',
    ];
}
