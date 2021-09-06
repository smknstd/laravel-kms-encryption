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
        $clientParams = [
            'version' => '2014-11-01',
        ];

        if (config('services.kms.key') && config('services.kms.secret')) {
            $clientParams['credentials'] = [
                'key' => config('services.kms.key'),
                'secret' => config('services.kms.secret'),
            ];
        }

        if (config('services.kms.region')) {
            $clientParams['region'] = config('services.kms.region');
        }

        $this->app->bind(KmsClient::class, fn () => new KmsClient($clientParams));

        $this->app->singleton(KmsEncrypter::class, function () {
            $client = $this->app->make(KmsClient::class);

            return new KmsEncrypter(
                $client,
                config('kms-encryption.key_id'),
                config('kms-encryption.context', [])
            );
        });

        $this->app->alias(KmsEncrypter::class, 'encrypter');

        $this->app->alias(KmsEncrypter::class, \Illuminate\Contracts\Encryption\Encrypter::class);

        $this->app->alias(KmsEncrypter::class, \Illuminate\Contracts\Encryption\StringEncrypter::class);
    }
}
