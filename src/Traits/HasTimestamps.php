<?php

namespace Delta4op\Mongodb\Traits;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

trait HasTimestamps
{
    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
    */
    public $createdAt;

    /**
     * @var ?Carbon
     * @ODM\Field(type="carbon")
     */
    public $updatedAt;

    /**
     * @return ?Carbon
     */
    public function getCreatedAt(): ?Carbon
    {
        return $this->createdAt;
    }

    /**
     * @param ?Carbon $createdAt
     * @return self
     */
    public function setCreatedAt(?Carbon $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return ?Carbon
     */
    public function getUpdatedAt(): ?Carbon
    {
        return $this->updatedAt;
    }

    /**
     * @param ?Carbon $updatedAt
     * @return self
     */
    public function setUpdatedAt(?Carbon $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ODM\PrePersist
     * @return self
     */
    public function markCreatedAtTimestamp(): static
    {
        if(!$this->createdAt) {
            $this->setCreatedAt(now());
        }

        return $this;
    }

    /**
     * @ODM\PreUpdate
     * @return self
     */
    public function markUpdatedAtTimestamp(): static
    {
        if(!$this->createdAt) {
            $this->setUpdatedAt(now());
        }

        return $this;
    }
}
