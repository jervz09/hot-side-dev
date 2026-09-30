<?php

declare(strict_types=1);

require_once __DIR__ . '/../config.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
} catch (mysqli_sql_exception $e) {
    error_log('DB connect error: ' . $e->getMessage());
    http_response_code(500);
    exit('Database connection error.');
}
