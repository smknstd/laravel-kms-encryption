<?php
// config for Smknstd/LaravelKmsEncryption
return [

    // kms key id as seen in aws's kms dashboard (usually it looks like uuid)
    'key_id' => '',

    // Associative array of custom encryption's context
    // warning: when changed you won't be able to decrypt previously encrypted data
    'context' => [
        // 'my_secret_key' => 'my_secret_value'
    ]
];
