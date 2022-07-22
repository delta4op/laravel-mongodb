<?php

use Delta4op\MongoODM\Facades\Mongodb;
use Delta4op\MongoODM\Managers\DocumentManager;

if (!function_exists('documentManager')) {
    /**
     * Shortcut to get document manager
     *
     * @param null $name
     * @return DocumentManager
     */
    function documentManager($name = null): DocumentManager
    {
        return Mongodb::manager($name);
    }
}

if (!function_exists('dm')) {
    /**
     * Alias to get document manager
     *
     * @param null $name
     * @return DocumentManager
     */
    function dm($name = null): DocumentManager
    {
        return documentManager($name);
    }
}