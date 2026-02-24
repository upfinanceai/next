<?php

namespace Modules\Card\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\Concerns\BelongsToCustomer;

class CardHolder extends Model
{
    use BelongsToCustomer;

    protected $guarded = [];

    protected $casts = [
        'request' => 'array',
        'payload' => 'array',
    ];
}
