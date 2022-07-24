<?php

use Delta4op\Mongodb\Repositories\DocumentRepository;

return [

    'default' => 'mongodb',

    'connections' => [
        'mongodb' => [
            'driver' => env('DB_CONNECTION'),
            'dsn' => env('DB_URI'),
            'database' => env('DB_DATABASE'),

            'defaultRepository' => DocumentRepository::class,
            'paths' => [base_path('app/Services/ODM/Documents')],
            'metadata' => [base_path('app/Services/ODM/Metadata')],

            'proxies' => [
                'namespace' => 'Proxies',
                'path' => storage_path('proxies'),
                'auto_generate' => env('DOCTRINE_PROXY_AUTOGENERATE', false)
            ],

            'hydrators' => [
                'namespace' => 'Hydrators',
                'path' => storage_path('hydrators'),
            ],
        ],
    ],

];
