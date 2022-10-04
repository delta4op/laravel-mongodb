<?php

return [

    'default' => 'mongodb',

    /**
     * Define custom types over here
     * Refer to below link for more info
     * https://github.com/delta4op/laravel-mongodb/wiki
    */
    'types' => [

    ],

    'connections' => [
        'mongodb' => [

            /**
             * Mandatory field
             * Database connection string
             */
            'dsn' => env('MONGO_DSN'),

            /**
             * Mandatory field
             * Name of the target database
             */
            'database' => env('MONGO_DATABASE'),

            /**
             * Mandatory field
             * Paths to folders that contains documents
            */
            'paths' => [base_path('app/Services/ODM/Documents')],

            /**
             * Optional
             * By default
             * is used. You can create your own custom repository and define it here.
             * The custom repository should extend to the library's repository.
            */
            'defaultRepository' => Delta4op\Mongodb\Repositories\DocumentRepository::class,

            /**
             * Optional
             * Path to proxies
             */
            'proxies' => [
                'namespace' => 'Proxies',
                'path' => storage_path('proxies'),
                'auto_generate' => env('DOCTRINE_PROXY_AUTOGENERATE', false)
            ],

            /**
             * Optional
             * Path to hydrators
             */
            'hydrators' => [
                'namespace' => 'Hydrators',
                'path' => storage_path('hydrators'),
            ],
        ],
    ],
];
