<?php

namespace Modules\Transaction\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Support\Models\HasIdPrefix;

class LedgerEntry extends Model
{
    use HasIdPrefix;

    public $idPrefix = 'le_';

    protected $guarded = [];
}
