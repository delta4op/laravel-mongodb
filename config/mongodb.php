<?php

return [

    'default' => env('MONGO_DEFAULT_CONNECTION', 'mongodb'),

    /**
     * Define custom types over here
     * Refer to below link for more info
     * https://github.com/delta4op/laravel-mongodb/wiki
     */
    'types' => [
        // 'customType' => 'customTypeClass'
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
            'path' => base_path('Commands/Mongo/Documents'),

            /**
             * Optional
             * By default the given repository is used
             * You can create your own custom repository and define it here.
             * The custom repository should extend to the library's repository.
             */
            'defaultRepository' => Delta4op\Mongodb\Repositories\DocumentRepository::class,

            /**
             * Optional
             * If you wish to have your own base document class then
             * define it here. The make:document command will pick this up
             * and create document class accordingly
             */
            'baseDocument' => Delta4op\Mongodb\Documents\Document::class,

            /**
             * Optional
             * If you wish to have your own base embedded document class then
             * define it here. The make:embeddedDocument command will pick this up
             * and create embedded document class accordingly
             */
            'baseEmbeddedDocument' => Delta4op\Mongodb\Documents\EmbeddedDocument::class,

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
