<?php

namespace Delta4op\Mongodb\Helpers;

use Doctrine\ODM\MongoDB\Iterator\Iterator;
use Doctrine\ODM\MongoDB\MongoDBException;
use Doctrine\ODM\MongoDB\Query\Builder;
use InvalidArgumentException;
use MongoDB\DeleteResult;
use MongoDB\InsertOneResult;
use MongoDB\UpdateResult;

class Paginator
{

    protected Builder $queryBuilder;

    /**
     * @param Builder $queryBuilder
     */
    protected function __construct(Builder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * Fluent API constructor method
     *
     * @param Builder $queryBuilder
     * @return static
     */
    public static function create(Builder $queryBuilder): static
    {
        return new static($queryBuilder);
    }

    /**
     * @param int $val
     * @return $this
     */
    public function perPage(int $val): static
    {
        if($val < 0){
            throw new InvalidArgumentException('value should be 0 or greater');
        }

        $this->perPage = $val;

        return $this;
    }

    /**
     * @param int $val
     * @return $this
     */
    public function currentPage(int $val): static
    {
        if($val < 0){
            throw new InvalidArgumentException('value should be 0 or greater');
        }

        $this->currentPage = $val;

        return $this;
    }

    /**
     * @param bool $asArray
     * @return array|Iterator|int|DeleteResult|UpdateResult|InsertOneResult|null
     * @throws MongoDBException
     */
    public function getResult(bool $asArray = true): array|Iterator|int|DeleteResult|UpdateResult|InsertOneResult|null
    {
        $result = $this->queryBuilder
            ->limit($this->perPage)
            ->skip(($this->currentPage - 1))
            ->getQuery()
            ->execute();

        if($asArray) {
            $result = $result->toArray();
        }

        return $result;
    }
}
