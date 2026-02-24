<?php

namespace Modules\Customer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Customer\Database\factories\CustomerFactory;

class Customer extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'meta' => 'array',
    ];

    protected static function newFactory()
    {
        return CustomerFactory::new();
    }
}
