<?php
namespace Delta4op\Mongodb\Facades;

use Delta4op\Mongodb\Managers\DocumentManager;
use Delta4op\Mongodb\MongoContainer;
use Illuminate\Support\Facades\Facade;

/**
 * @method static DocumentManager manager(string $name = null)
 *
 * @see MongoContainer
*/
class Mongodb extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'mongodb';
    }
}
