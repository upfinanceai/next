<?php

namespace Modules\Transaction\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Support\Models\HasIdPrefix;
use Modules\Support\Models\Metable;

class Transaction extends Model
{
    use HasIdPrefix;
    use Metable;

    public $idPrefix = 'tx_';

    protected $guarded = [];

    protected $casts = [
        'meta' => 'array',
    ];
}
