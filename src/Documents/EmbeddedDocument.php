<?php

namespace Delta4op\Mongodb\Documents;

use Illuminate\Contracts\Support\Arrayable;

abstract class EmbeddedDocument
{
    /**
     * @return static
     */
    public static function make(): static
    {
        return new static;
    }
}
