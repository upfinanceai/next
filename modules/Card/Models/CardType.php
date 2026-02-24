<?php

namespace Modules\Card\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\Concerns\Metable;

class CardType extends Model
{
    use Metable;
    protected $guarded = [];
}
