# Laravel Kms Encryption

[![Latest Version on Packagist](https://img.shields.io/packagist/v/smknstd/laravel-kms-encryption.svg?style=flat-square)](https://packagist.org/packages/smknstd/laravel-kms-encryption)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/smknstd/laravel-kms-encryption/run-tests?label=tests)](https://github.com/smknstd/laravel-kms-encryption/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/smknstd/laravel-kms-encryption/Check%20&%20fix%20styling?label=code%20style)](https://github.com/smknstd/laravel-kms-encryption/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/smknstd/laravel-kms-encryption.svg?style=flat-square)](https://packagist.org/packages/smknstd/laravel-kms-encryption)

## Introduction

This package replaces Laravel's built-in encryption with an encryption based on AWS KMS.

Two major features provided by kms are:
- ability to automatically [rotate key](https://docs.aws.amazon.com/kms/latest/developerguide/rotate-keys.html) (annually) without deleting the previous ones
- you don’t have access to the actual key, which means you can’t leak it

_This package has been based on this [blogpost](https://blog.deleu.dev/swapping-laravel-encryption-with-aws-kms/)_

## Installation

This package requires Laravel 8.x or higher.

You can install the package via composer:

```bash
composer require smknstd/laravel-kms-encryption
```

Next you should publish the config file, and setup your values :

```bash
php artisan vendor:publish --provider="Smknstd\LaravelKmsEncryption\LaravelKmsEncryptionServiceProvider"
```

If you want to use IAM Roles that are already setup, aws sdk will automatically use them by default. Otherwise, you should setup credentials to the proper aws user [allowed](https://docs.aws.amazon.com/kms/latest/developerguide/key-policies.html#key-policy-default-allow-users) to "use" the given kms key, by adding a kms section in your `config/services.php` file :

```
    'kms' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_REGION'),
    ],
```

Now everytime you'll [encrypt](https://laravel.com/docs/8.x/encryption) something it will use the provided kms key. It includes all fields using eloquent's [encrypted casting](https://laravel.com/docs/8.x/eloquent-mutators#encrypted-casting). If you have previously encrypted data, be aware that you won't be able to decrypt it.

### Cookies encryption

If you use laravel's middleware `EncryptCookies`, it can't work with kms. To let the middleware continue working with laravel's encrypter you need to edit `App\Http\kernel.php`. Just replace the existing middleware with :

```
   protected $middlewareGroups = [
     'web' => [
         \Smknstd\LaravelKmsEncryption\Middleware\EncryptCookies::class,
         ...
     ]
   ]
```

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Arnaud Becher](https://github.com/smknstd)
- [Marco Aurélio Deleu](https://github.com/deleugpn)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
