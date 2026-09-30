<?php

declare(strict_types=1);

/**
 * Session guard helpers.
 *
 * Including this file does nothing by default (public pages include it via
 * head.php). Call the functions below on pages that require auth:
 *
 *   require_verified_login('../');  // page lives one dir deeper than root
 *   require_verified_login('');     // page lives in the project root
 */
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function require_verified_login(string $rootPrefix = ''): void
{
    if (empty($_SESSION['id'])) {
        header('location: ' . $rootPrefix . 'login.php');
        exit;
    }

    if (empty($_SESSION['verified'])) {
        header('location: ' . $rootPrefix . 'verify_check.php');
        exit;
    }
}
