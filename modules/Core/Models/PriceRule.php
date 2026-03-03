<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Enums\PriceRuleScene;
use Modules\Core\Models\Concerns\Activable;

class PriceRule extends Model
{
    use Activable;

    protected $guarded = [];

    protected $casts = [
        'scene'      => PriceRuleScene::class,
        'conditions' => 'array',
        'prices'     => 'array',
    ];

}
