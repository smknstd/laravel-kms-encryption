<?php

namespace Smknstd\LaravelKmsEncryption\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as LaravelEncryptCookies;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Str;

class EncryptCookies extends LaravelEncryptCookies
{
    /**
     * Create a new CookieGuard instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->encrypter = new Encrypter(
            $this->parseKey(config('app.key')),
            config('app.cipher')
        );
    }

    /**
     * Parse the encryption key.
     *
     * @param  array  $config
     * @return string
     */
    protected function parseKey($key)
    {
        if (Str::startsWith($key, $prefix = 'base64:')) {
            $key = base64_decode(Str::after($key, $prefix));
        }

        return $key;
    }
}
