# Laravel mongodb

[comment]: <> ([![Latest Version on Packagist]&#40;https://img.shields.io/packagist/v/:vendor_slug/:package_slug.svg?style=flat-square&#41;]&#40;https://packagist.org/packages/:vendor_slug/:package_slug&#41;)

[comment]: <> ([![GitHub Tests Action Status]&#40;https://img.shields.io/github/workflow/status/:vendor_slug/:package_slug/run-tests?label=tests&#41;]&#40;https://github.com/:vendor_slug/:package_slug/actions?query=workflow%3Arun-tests+branch%3Amain&#41;)

[comment]: <> ([![GitHub Code Style Action Status]&#40;https://img.shields.io/github/workflow/status/:vendor_slug/:package_slug/Check%20&%20fix%20styling?label=code%20style&#41;]&#40;https://github.com/:vendor_slug/:package_slug/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain&#41;)

[comment]: <> ([![Total Downloads]&#40;https://img.shields.io/packagist/dt/:vendor_slug/:package_slug.svg?style=flat-square&#41;]&#40;https://packagist.org/packages/:vendor_slug/:package_slug&#41;)

This package is a laravel friendly wrapper around [mongodb-odm](https://github.com/doctrine/mongodb-odm) library which provides a PHP object mapping functionality for MongoDB. This package which supports multiple connections and multi-collection transactions (use with caution).

## Installation

You can install the package via composer:

```bash
composer require delta4op/laravel-mongodb
```

Publish the config file with: **MANDATORY**

```bash
php artisan vendor:publish --tag=":laravel-mongodb-config"
```

This is the contents of the published config file:

```php
return [

    'default' => 'cms',

    'connections' => [
        'c1' => [
            'driver' => env('DB_CONNECTION'),
            'dsn' => env('DB_URI'),
            'database' => env('DB_DATABASE'),

            'defaultRepository' => \Delta4op\MongoODM\Repositories\DocumentRepository::class,
            'paths' => [base_path('app/Services/ODM/Documents')],
            'metadata' => [base_path('app/Services/ODM/Metadata')],
        ],
    ],


    'proxies' => [
        'namespace' => 'Proxies',
        'path' => storage_path('proxies'),
        'auto_generate' => env('DOCTRINE_PROXY_AUTOGENERATE', false)
    ],

    'hydrators' => [
        'namespace' => 'Hydrators',
        'path' => storage_path('hydrators'),
    ],
];
```

## Accessing document manager
```php
Mongodb::manager()->persist($document);

// specify connection
Mongodb::manager('db2')->persist($document);

// helper method
dm('db2')->persist($document);
```

## Multi Collection Transactions
This approach is only possible if you do not rely on the built-in events system of doctrine, because odm is not aware of the transaction and fires the “post-flush” events as soon as the db command is executed.
The other problem is that after a rollback the unit of work is in an inconsistent state which must be handled “manually” (e.g. clear or restore the state the uow had before the flush call).
```php
dm()->startTransaction();
try {
    
    // your code that will probably have
    // multiple document persists
    
    dm()->flush(['session' => tdm()->getSession()]);
    dm()->commitTransaction();
} catch (Exception $exception) {
    dm()->abortTransaction();
    throw $exception;
}
```
## Custom Types
The package comes with Carbon type support. You can create your own type by extending `Doctrine\ODM\MongoDB\Types\Type` and add it to the `MongoServiceProvider`
```php
class MongoServiceProvider extends PackageServiceProvider
{
    /**
     * Custom type mappings
     *
     * @var array
     */
    public array $types = [
        'customType' => CustomType::class
    ];
}
```
## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Ravish Patel](https://github.com/delta4op)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
