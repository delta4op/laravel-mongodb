# Laravel mongodb

[comment]: <> ([![Latest Version on Packagist]&#40;https://img.shields.io/packagist/v/:vendor_slug/:package_slug.svg?style=flat-square&#41;]&#40;https://packagist.org/packages/:vendor_slug/:package_slug&#41;)

[comment]: <> ([![GitHub Tests Action Status]&#40;https://img.shields.io/github/workflow/status/:vendor_slug/:package_slug/run-tests?label=tests&#41;]&#40;https://github.com/:vendor_slug/:package_slug/actions?query=workflow%3Arun-tests+branch%3Amain&#41;)

[comment]: <> ([![GitHub Code Style Action Status]&#40;https://img.shields.io/github/workflow/status/:vendor_slug/:package_slug/Check%20&%20fix%20styling?label=code%20style&#41;]&#40;https://github.com/:vendor_slug/:package_slug/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain&#41;)

[comment]: <> ([![Total Downloads]&#40;https://img.shields.io/packagist/dt/:vendor_slug/:package_slug.svg?style=flat-square&#41;]&#40;https://packagist.org/packages/:vendor_slug/:package_slug&#41;)

This package is a laravel friendly wrapper around [mongodb-odm](https://github.com/doctrine/mongodb-odm) library which provides a PHP object mapping functionality for MongoDB. This package which supports multiple connections and multi-collection transactions (use with caution).

Checkout my [Documentation](https://delta4op.gitbook.io/laravel-odm/) to get started.
## Installation

You can install the package via composer:

```bash
composer require delta4op/laravel-mongodb
```

Publish the config file with: **MANDATORY**

```bash
php artisan vendor:publish --tag=":laravel-mongodb-config"
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
