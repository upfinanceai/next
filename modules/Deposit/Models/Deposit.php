<?php

namespace Modules\Deposit\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\Approvable;
use Modules\Core\Models\Concerns\Metable;

class Deposit extends Model implements Approvable
{
    use Metable;

    protected $guarded = [];

    protected $casts = [
        'request_payload' => 'array',
        'result_payload'  => 'array',
    ];
}
