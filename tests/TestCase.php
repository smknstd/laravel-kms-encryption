<?php

namespace Smknstd\LaravelKmsEncryption\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Smknstd\LaravelKmsEncryption\LaravelKmsEncryptionServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelKmsEncryptionServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
    }
}
