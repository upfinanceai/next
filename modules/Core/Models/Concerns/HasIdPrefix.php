<?php

namespace Modules\Core\Models\Concerns;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Support\Str;

/**
 * @property string $idPrefix
 * @method string getIdPrefix()
 */
trait HasIdPrefix
{
    use HasUlids;

    public function newUniqueId(): string
    {
        if (method_exists($this, 'getIdPrefix')) {
            $prefix = $this->getIdPrefix();
        } else {
            $prefix = $this->idPrefix ?? '';
        }
        return $prefix . strtolower((string)Str::ulid());
    }
}

