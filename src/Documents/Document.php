<?php

namespace Delta4op\Mongodb\Documents;

use Delta4op\Mongodb\Facades\Mongodb;
use Delta4op\Mongodb\Managers\DocumentManager;
use Doctrine\ODM\MongoDB\Query\Builder;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

abstract class Document
{
    /**
     * Connection name
     *
     * @var null|string
     */
    const CONNECTION = null;

    /**
     * Returns primary key
     *
     * @return null
     */
    public function getKey()
    {
        return $this->id;
    }

    /**
     * @return DocumentRepository
     */
    public static function repository(): DocumentRepository
    {
        return static::manager()->getRepository(static::class);
    }

    /**
     * @return Builder
     */
    public static function queryBuilder(): Builder
    {
        return static::manager()->createQueryBuilder(static::class);
    }

    /**
     * @return DocumentManager
     */
    public static function manager(): DocumentManager
    {
        return Mongodb::manager(static::CONNECTION ?? null);
    }
}
