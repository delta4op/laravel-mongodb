<?php

namespace Delta4op\Mongodb\Traits;

use Delta4op\Mongodb\Repositories\DocumentRepository;
use Delta4op\Mongodb\Facades\Mongodb;

trait HasRepository
{
    /**
     * @return DocumentRepository
     */
    public static function repository(): DocumentRepository
    {
        return Mongodb::manager()->getRepository(get_called_class());
    }
}
