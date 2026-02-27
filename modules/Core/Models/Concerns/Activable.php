<?php

namespace Modules\Core\Models\Concerns;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Model
 */
trait Activable
{
    public static string $activeField = 'active';

    public function scopeActive($query)
    {
        return $query->where(static::getActiveField(), true);
    }

    public function scopeInactive($query)
    {
        return $query->where(static::getActiveField(), false);
    }

    public function initializeActivable(): void
    {
        $this->casts = array_merge($this->casts, [
            static::getActiveField() => 'boolean',
        ]);
    }

    protected function getActiveField(): string
    {
        return static::$activeField;
    }
}
