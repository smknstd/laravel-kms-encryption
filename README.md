# Laravel Kms Encryption

[![Latest Version on Packagist](https://img.shields.io/packagist/v/smknstd/laravel-kms-encryption.svg?style=flat-square)](https://packagist.org/packages/smknstd/laravel-kms-encryption)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/smknstd/laravel-kms-encryption/run-tests?label=tests)](https://github.com/smknstd/laravel-kms-encryption/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/smknstd/laravel-kms-encryption/Check%20&%20fix%20styling?label=code%20style)](https://github.com/smknstd/laravel-kms-encryption/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/smknstd/laravel-kms-encryption.svg?style=flat-square)](https://packagist.org/packages/smknstd/laravel-kms-encryption)

## Introduction

This package replaces Laravel's built-in encryption with an encryption based on AWS KMS

## Installation

This package requires Laravel 8.x or higher.

You can install the package via composer:

```bash
composer require smknstd/laravel-kms-encryption
```

Next you should publish the config file, and update with your kms key id (previously setup in aws) and context array :

```bash
php artisan vendor:publish --provider="Smknstd\LaravelKmsEncryption\LaravelKmsEncryptionServiceProvider" --tag="config"
```

In your `config/services.php` file setup:

'kms' => [
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_REGION'),
],

Now everytime you'll [encrypt](https://laravel.com/docs/8.x/encryption) something it will use the provided kms key. It also work with eloquent's [encrypted casting](https://laravel.com/docs/8.x/eloquent-mutators#encrypted-casting).


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Arnaud Becher](https://github.com/smknstd)
- [Marco Aurélio Deleu](https://github.com/deleugpn)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
