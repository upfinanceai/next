<?php

namespace Modules\Core\Abstracts;

class Service
{
    public static function make(...$args): static
    {
        return new static(...$args);
    }
}
