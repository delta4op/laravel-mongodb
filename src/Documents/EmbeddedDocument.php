<?php

namespace Delta4op\Mongodb\Documents;

use Illuminate\Contracts\Support\Arrayable;

abstract class EmbeddedDocument implements Arrayable
{
    use Common;

    public function toArray(): array
    {
        return [];
    }
}
