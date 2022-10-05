<?php

namespace Delta4op\Mongodb\Traits;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

trait HasDeletedAt
{
    /**
     * @var \Illuminate\Support\Carbon
     * @ODM\Field(type="carbon")
     */
    private $deletedAt;

    /**
     * @return \Illuminate\Support\Carbon
     */
    public function getDeletedAt(): \Illuminate\Support\Carbon
    {
        return $this->deletedAt;
    }

    /**
     * @param \Illuminate\Support\Carbon $deletedAt
     */
    public function setDeletedAt(\Illuminate\Support\Carbon $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @return self
     */
    public function markAsDeleted(): self
    {
        $this->setDeletedAt(now());

        return $this;
    }
}
