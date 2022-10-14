<?php

namespace Delta4op\Mongodb\Types;

use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;
use Illuminate\Support\Carbon;
use MongoDB\BSON\UTCDateTime;

class CarbonDate extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): ?UTCDateTime
    {
        return isset($value) ? new UTCDateTime($value) : null;
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
            $instance = new Carbon($value->toDateTime());

            if($tz = config('app.timezone')) {
                $instance->setTimezone($tz);
            }

            return $instance;
        }

        return $value;
    }
}
