<?php

namespace Modules\Account\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Support\Models\HasIdPrefix;

class Account extends Model
{
    use HasIdPrefix;

    public $idPrefix = 'acc_';

    protected $guarded = [];
}
