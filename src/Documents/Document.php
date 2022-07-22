<?php

namespace Delta4op\MongoODM\Documents;

use Delta4op\MongoODM\Repositories\DocumentRepository;
use Delta4op\MongoODM\Facades\Mongodb;
use Doctrine\ODM\MongoDB\Query\Builder;
use Illuminate\Support\Str;

abstract class Document
{
    use Common;

    /**
     * Collection name
     *
     * @var string
     */
    protected string $collection;
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected string $primaryKey = 'id';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected string $keyType = 'string';

    /**
     * Returns name of the collection the document belongs to
     *
     * @return string
     */
    public function getCollectionName() : string
    {
        return $this->collection ?? Str::snake(Str::pluralStudly(class_basename($this)));
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->{$this->getKeyName()};
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType(): string
    {
        return $this->keyType;
    }

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName(): string
    {
        return $this->primaryKey;
    }

    /**
     * @return Builder
     */
    public static function queryBuilder(): Builder
    {
        return Mongodb::createQueryBuilder(get_called_class());
    }

    abstract public static function repository(): DocumentRepository;

    public function toArray(): array
    {
        return [];
    }
}
