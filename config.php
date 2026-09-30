<?php

declare(strict_types=1);

/**
 * Central application configuration.
 *
 * Reads from environment variables, falling back to sensible local
 * development defaults. Copy .env.example to .env and fill in real values.
 */

function env(string $key, ?string $default = null): ?string
{
    $value = getenv($key);
    if ($value === false || $value === '') {
        return $default;
    }
    return $value;
}

// --- Application -----------------------------------------------
define('APP_URL', env('APP_URL', 'http://localhost/hot-side-dev'));

// --- Database --------------------------------------------------
define('DB_HOST', env('DB_HOST', 'localhost'));
define('DB_USER', env('DB_USER', 'root'));
define('DB_PASS', env('DB_PASS', ''));
define('DB_NAME', env('DB_NAME', 'hot-side'));

// --- SMTP / email ----------------------------------------------
define('SMTP_HOST', env('SMTP_HOST', 'smtp.gmail.com'));
define('SMTP_PORT', (int) env('SMTP_PORT', '465'));
define('SMTP_ENCRYPTION', env('SMTP_ENCRYPTION', 'ssl'));
define('SMTP_USERNAME', env('SMTP_USERNAME', ''));
define('SMTP_PASSWORD', env('SMTP_PASSWORD', ''));
define('MAIL_FROM', env('MAIL_FROM', SMTP_USERNAME));
