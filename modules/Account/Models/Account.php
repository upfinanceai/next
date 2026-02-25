<?php

namespace Modules\Account\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Account\Enums\AccountCategory;
use Modules\Account\Enums\AccountStatus;
use Modules\Core\Enums\BlockChains;

class Account extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'chain'    => BlockChains::class . ':nullable',
        'category' => AccountCategory::class,
        'status'   => AccountStatus::class,
    ];

    public function owner(): MorphTo
    {
        return $this->morphTo();
    }

    public function getIsAssetAttribute()
    {
        return $this->category->equals(AccountCategory::ASSET(), AccountCategory::REVENUE());
    }
}
