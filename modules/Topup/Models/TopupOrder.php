<?php

namespace Modules\Topup\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Support\Models\HasIdPrefix;

class TopupOrder extends Model
{
    use HasIdPrefix;

    public $idPrefix = 'tup_';

    protected $guarded = [];
}
