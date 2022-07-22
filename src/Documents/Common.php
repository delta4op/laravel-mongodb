<?php

namespace Delta4op\Mongodb\Documents;

use Delta4op\Mongodb\Traits\CanFillClassProperties;

trait Common
{
    use CanFillClassProperties;

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }
}
