<?php

namespace Modules\Customer\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Support\Models\HasIdPrefix;

class Customer extends Authenticatable
{
    use HasIdPrefix;

    public $idPrefix = 'cus_';

    protected $guarded = [];

    protected $casts = [
        'meta' => 'array',
    ];
}
