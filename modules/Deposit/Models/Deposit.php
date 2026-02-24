<?php

namespace Modules\Deposit\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\Concerns\Metable;

class Deposit extends Model
{
    use Metable;

    protected $guarded = [];

    protected $casts = ['payload' => 'array'];
}
