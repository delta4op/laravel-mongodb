<?php

namespace Delta4op\Mongodb\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\EmbeddedDocument
 */
class GeoPoint extends EmbeddedDocument
{
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    protected $type = 'Point';

    /**
     * @var float[]
     * @ODM\Field(type="collection")
     */
    protected $coordinates = [];

    /**
     * @param float $longitude
     * @param float $latitude
     * @return self
     */
    public static function createFromCoordinates(float $longitude, float $latitude): self
    {
        $instance = new self;
        $instance->coordinates = [$longitude, $latitude];
        return $instance;
    }

    public function getLatitude(): ?float
    {
        return $this->coordinates[1] ?? null;
    }

    public function getLongitude(): ?float
    {
        return $this->coordinates[0] ?? null;
    }

    /**
     * @return float[]
     */
    public function getCoordinates(): array
    {
        return $this->coordinates;
    }

    /**
     * @param float[] $coordinates
     * @return GeoPoint
     */
    public function setCoordinates(array $coordinates): GeoPoint
    {
        $this->coordinates = $coordinates;
        return $this;
    }
}
