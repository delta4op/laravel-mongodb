<?php

namespace Delta4op\Mongodb\Documents;

use Delta4op\Mongodb\Facades\Mongodb;
use Delta4op\Mongodb\Managers\DocumentManager;
use Doctrine\ODM\MongoDB\Query\Builder;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

abstract class Document
{
    use Common;

    /**
     * Collection name
     *
     * @var null|string
     */
    const CONNECTION = 'cms';

    /**
     * @return DocumentRepository
     */
    public static function repository(): DocumentRepository
    {
        return static::getManager()->getRepository(static::class);
    }

    /**
     * @return Builder
     */
    public static function query(): Builder
    {
        return static::getManager()->createQueryBuilder(static::class);
    }

    /**
     * @return DocumentManager
     */
    public static function getManager(): DocumentManager
    {
        return Mongodb::manager(static::CONNECTION ?? null);
    }
}
