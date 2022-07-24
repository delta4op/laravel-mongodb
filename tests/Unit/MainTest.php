<?php

use Delta4op\Mongodb\Facades\Mongodb;
use Delta4op\Mongodb\Managers\DocumentManager;

// config file not found

// no default connection found

// throws exception for invalid config values

it('throws exception for invalid config values', function(){
    $manager = Mongodb::manager();


    expect($manager)->toBeInstanceOf(DocumentManager::class);
});

it('returns default manager object', function(){
    $manager = Mongodb::manager();

    expect($manager)->toBeInstanceOf(DocumentManager::class);
});
