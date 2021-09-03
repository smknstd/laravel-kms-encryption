<?php

declare(strict_types=1);

namespace Smknstd\LaravelKmsEncryption;

use Aws\Exception\AwsException;
use Aws\Kms\KmsClient;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Contracts\Encryption\StringEncrypter;

final class KmsEncrypter implements Encrypter, StringEncrypter
{
    private KmsClient $client;

    private string $keyId;

    private array $encryptionContext;

    public function __construct(KmsClient $client, string $kmsKeyId, array $kmsEncryptionContext)
    {
        $this->client = $client;
        $this->keyId = $kmsKeyId;
        $this->encryptionContext = $kmsEncryptionContext;
    }

    public function encrypt($value, $serialize = true)
    {
        try {
            return base64_encode($this->client->encrypt([
                'KeyId' => $this->keyId,
                'Plaintext' => $serialize ? serialize($value) : $value,
                'EncryptionContext' => $this->encryptionContext,
            ])->get('CiphertextBlob'));
        } catch (AwsException $e) {
            throw new EncryptException($e->getMessage(), (int) $e->getCode(), $e);
        }
    }

    public function decrypt($payload, $unserialize = true)
    {
        try {
            $result = $this->client->decrypt([
                'CiphertextBlob' => base64_decode($payload),
                'EncryptionContext' => $this->encryptionContext,
            ]);

            $decrypted = $result['Plaintext'];

            return $unserialize ? unserialize($decrypted) : $decrypted;
        } catch (AwsException $e) {
            throw new DecryptException($e->getMessage(), (int) $e->getCode(), $e);
        }
    }

    public function encryptString($value): string
    {
        return $this->encrypt($value, false);
    }

    public function decryptString($payload): string
    {
        return $this->decrypt($payload, false);
    }
}
