<?php

namespace Delta4op\Mongodb\Traits;

use Delta4op\Mongodb\DocumentRepositories\DocumentRepository;
use Delta4op\Mongodb\Facades\Mongodb;

trait HasRepository
{
    /**
     * @return DocumentRepository
     */
    public static function repository(): DocumentRepository
    {
        return Mongodb::getRepository(get_called_class());
    }
}
