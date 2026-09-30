<?php

declare(strict_types=1);

require_once __DIR__ . '/../config.php';

function decamelize(string $string): string
{
    return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', preg_replace('/\s+/', '', $string)));
}

/**
 * AES-128-CTR encrypt/decrypt helper used for password-reset links.
 *
 * Ciphertext format: base64(IV . ciphertext) so every encryption
 * produces a different output for the same input.
 */
function let_crypt(string $string, bool $encrypt = false): string
{
    $ciphering = 'AES-128-CTR';

    if ($encrypt) {
        $iv = random_bytes(openssl_cipher_iv_length($ciphering));
        $encrypted = openssl_encrypt($string, $ciphering, CRYPT_KEY, 0, $iv);

        return $encrypted === false ? '' : base64_encode($iv . $encrypted);
    }

    $raw = base64_decode($string, true);
    if ($raw === false) {
        return '';
    }

    $ivLength = openssl_cipher_iv_length($ciphering);
    if (strlen($raw) <= $ivLength) {
        return '';
    }

    $iv = substr($raw, 0, $ivLength);
    $cipherText = substr($raw, $ivLength);

    $decrypted = openssl_decrypt($cipherText, $ciphering, CRYPT_KEY, 0, $iv);

    return $decrypted === false ? '' : $decrypted;
}
