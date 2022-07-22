<?php

namespace Delta4op\MongoODM\Types;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;
use MongoDB\BSON\UTCDateTime;

class CarbonDate extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): ?UTCDateTime
    {
        return !$value ? new UTCDateTime($value) : null;
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    public function convertToPHPValue($value): mixed
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof UTCDateTime){
            return (new Carbon($value->toDateTime()));
        }

        return $value;
    }
}
