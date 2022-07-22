# Laravel mongodb

[comment]: <> ([![Latest Version on Packagist]&#40;https://img.shields.io/packagist/v/:vendor_slug/:package_slug.svg?style=flat-square&#41;]&#40;https://packagist.org/packages/:vendor_slug/:package_slug&#41;)

[comment]: <> ([![GitHub Tests Action Status]&#40;https://img.shields.io/github/workflow/status/:vendor_slug/:package_slug/run-tests?label=tests&#41;]&#40;https://github.com/:vendor_slug/:package_slug/actions?query=workflow%3Arun-tests+branch%3Amain&#41;)

[comment]: <> ([![GitHub Code Style Action Status]&#40;https://img.shields.io/github/workflow/status/:vendor_slug/:package_slug/Check%20&%20fix%20styling?label=code%20style&#41;]&#40;https://github.com/:vendor_slug/:package_slug/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain&#41;)

[comment]: <> ([![Total Downloads]&#40;https://img.shields.io/packagist/dt/:vendor_slug/:package_slug.svg?style=flat-square&#41;]&#40;https://packagist.org/packages/:vendor_slug/:package_slug&#41;)

This package is a laravel friendly wrapper around [mongodb-odm](https://github.com/doctrine/mongodb-odm) package which supports multiple connections and transactions (use with caution). The package provides a PHP object mapping functionality for MongoDB.

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

## Usage

### Accessing document manager
```php
MongoDB::manager()->persist($document);

// specify connection
MongoDB::manager('db2')->persist($document);

// helper method
dm('db2')->persist($document);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/:author_username/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Ravish Patel](https://github.com/delta4op)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
