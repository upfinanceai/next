<?php

namespace Modules\Card\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Support\Models\HasIdPrefix;

class CardDesign extends Model
{
    use HasIdPrefix;

    protected $guarded = [];
}
