<?php

namespace Smknstd\LaravelKmsEncryption;

use Aws\Kms\KmsClient;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelKmsEncryptionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-kms-encryption')
            ->hasConfigFile();
    }

    public function packageRegistered()
    {
        $this->app->bind(KmsClient::class, fn() => new KmsClient([
            'version' => '2014-11-01',
            'credentials' => [
                'key'    => config('services.kms.key'),
                'secret' => config('services.kms.secret'),
            ],
            'region' => config('services.kms.region'),
        ]));

        $this->app->singleton(KmsEncrypter::class, function () {

            $client = $this->app->make(KmsClient::class);

            return new KmsEncrypter(
                $client,
                config('kms-encryption.key'),
                config('kms-encryption.context', [])
            );
        });

        $this->app->alias(KmsEncrypter::class, 'encrypter');

        $this->app->alias(KmsEncrypter::class, \Illuminate\Contracts\Encryption\Encrypter::class);

        $this->app->alias(KmsEncrypter::class, \Illuminate\Contracts\Encryption\StringEncrypter::class);
    }
}
