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
```

## `Document` and `Embedded Document` base classes
Every document and embedded document that you create should extend the base classes respectively.
```php
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\Mongodb\Documents\Document;

/**
* @ODM\Document(collection="users")
*/
class User extends Document {

}
```

```php
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\Mongodb\Documents\EmbeddedDocument;

/**
* @ODM\EmbeddedDocument
*/
class Address extends EmbeddedDocument {

}
```

## Getting Mongodb Manager
```php
// this command will return the default database connection defined as per config/mongodb.php
$dm = Mongodb::manager()

// this will return specific connection
$dm = Mongodb::manager('db2');

// There are helper methods that can be used alternatively as following
$dm = dm(); // similar to Mongodb::manager();
$dm = dm('db2'); // similar to  Mongodb::manager('db2')
```

## Saving document
```php
Mongodb::manager()->persist($document);
```

## Using Document repository
```php
$repository = User::repository();
$repository->find(123);
$repository->findOnBy([...])
$repository->findBy([...]);
$repository->findAll();
```
For more details check [this](https://www.doctrine-project.org/projects/doctrine-mongodb-odm/en/stable/reference/document-repositories.html#document-repositories)

## Creating Custom Repository
If you create custom repository for a collection then mention it as following
```php
use Delta4op\Mongodb\Repositories\DocumentRepository;

class UserRepository extends DocumentRepository {

    public function findActiveUsers()
    {
        return $this->findBy([
            'status' => 'ACTIVE'
        ]);
    }
}
```
using repository
```php
$repository = User::repository();
$activeUsers = $repository->findActiveUsers();
```
Define repository in document meta
```php
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\Mongodb\Documents\Document;

/**
* @ODM\Document(
*   collection="users",
*   repositoryClass=Repositories\UserRepository::class
* )
*/
class User extends Document {

}
```
Check [this](https://www.doctrine-project.org/projects/doctrine-mongodb-odm/en/stable/reference/document-repositories.html#custom-repositories) for more details on creating custom repository

## Using Query Builder
```PHP
$qb = User::queryBuilder();
$qb->field('email')->equals('test@sysotel.com')->getQuery()->execute()->toArray();
```
For more details check [this](https://www.doctrine-project.org/projects/doctrine-mongodb-odm/en/stable/reference/query-builder-api.html#query-builder-api)

## Multi Collection Transactions
This approach is only possible if you do not rely on the built-in events system of doctrine, because odm is not aware of the transaction and fires the “post-flush” events as soon as the db command is executed.
The other problem is that after a rollback the unit of work is in an inconsistent state which must be handled “manually” (e.g. clear or restore the state the uow had before the flush call).
```php
Mongodb::manager();
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
