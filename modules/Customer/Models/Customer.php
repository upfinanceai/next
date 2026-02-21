<?php

namespace Modules\Customer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Customer\Database\factories\CustomerFactory;
use Modules\Support\Models\HasIdPrefix;

class Customer extends Authenticatable
{
    use HasIdPrefix;
    use HasFactory;

    public $idPrefix = 'cus_';

    protected $guarded = [];

    protected $casts = [
        'meta' => 'array',
    ];

    protected static function newFactory()
    {
        return CustomerFactory::new();
    }
}
