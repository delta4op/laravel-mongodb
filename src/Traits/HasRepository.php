<?php

namespace Delta4op\MongoODM\Traits;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use Delta4op\MongoODM\Facades\Mongodb;

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
