<?php

namespace Modules\Support\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Model
 * @property array $meta
 */
trait Metable
{
    public static string $metaField = 'meta';

    public function initializeMetable(): void
    {
        $this->casts = array_merge($this->casts, [
            static::getMetaField() => 'array',
        ]);
    }

    public function setMeta($key, $value = null): void
    {
        $meta = $this->meta;

        if (is_string($key)) {
            $key = [
                $key => $value,
            ];
        }
        foreach ($key as $_key => $_value) {
            $meta[$_key] = $_value;
        }

        $this->syncMeta($meta);
    }

    public function syncMeta($meta = []): void
    {
        $this->update([$this->getMetaField() => $meta]);
    }

    protected function getMetaField(): string
    {
        return static::$metaField;
    }

    public function getMeta($key = null, $default = null)
    {
        $meta = $this->meta;

        if (empty($key)) {
            return $meta;
        }
        return $meta[$key] ?? $default;
    }

    public function clearMeta(): void
    {
        $this->syncMeta();
    }

    public function getMetaAttribute()
    {
        return to_json($this->attributes[$this->getMetaField()] ?? []);
    }

}
