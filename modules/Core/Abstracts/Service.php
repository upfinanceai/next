<?php

namespace Modules\Core\Abstracts;

abstract class Service
{
    public static function make(...$args): static
    {
        return new static(...$args);
    }
}
