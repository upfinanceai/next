<?php

namespace Modules\Account\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\Concerns\BelongsToCustomer;

class SavoAccount extends Model
{
    use BelongsToCustomer;
}
