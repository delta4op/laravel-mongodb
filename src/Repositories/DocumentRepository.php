<?php

namespace Delta4op\Mongodb\Repositories;

use Doctrine\ODM\MongoDB\Repository\DocumentRepository as BaseDocumentRepository;
use Illuminate\Support\Collection;

class DocumentRepository extends BaseDocumentRepository
{
    /**
     * Similar to findBy method.
     * Difference is it returns collection instead of array
     *
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return Collection
     */
    public function getBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null): Collection
    {
        return collect($this->findBy($criteria, $orderBy, $limit, $offset));
    }

    /**
     * Similar to findAll method.
     * Difference is it returns collection instead of array
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return collect($this->findAll());
    }
}
