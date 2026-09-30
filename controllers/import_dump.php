<?php

declare(strict_types=1);

/**
 * One-time setup script: imports ../database/dump.sql into the database.
 *
 * PROTECTED: requires SETUP_TOKEN env var. Run once, then remove this file
 * from a public server. Example:
 *   curl "http://localhost/hot-side-dev/controllers/import_dump.php?token=SECRET"
 */
require_once __DIR__ . '/../config.php';

$expectedToken = getenv('SETUP_TOKEN');
if ($expectedToken === false || $expectedToken === ''
    || !isset($_GET['token']) || !hash_equals($expectedToken, (string) $_GET['token'])) {
    http_response_code(403);
    exit('Forbidden. Set the SETUP_TOKEN environment variable and pass ?token=... to run the import.');
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$queryFile = __DIR__ . '/../database/dump.sql';
if (!is_file($queryFile)) {
    exit('dump.sql not found.');
}

$sql = file_get_contents($queryFile);
if ($sql === false || trim($sql) === '') {
    exit('dump.sql is empty.');
}

mysqli_select_db($conn, DB_NAME);

if (mysqli_multi_query($conn, $sql)) {
    do {
        if (($result = mysqli_store_result($conn)) === false && mysqli_error($conn) !== '') {
            echo 'Query failed: ' . mysqli_error($conn) . PHP_EOL;
        }
        if ($result instanceof mysqli_result) {
            $result->free();
        }
    } while (mysqli_more_results($conn) && mysqli_next_result($conn));

    echo 'Success';
} else {
    echo 'First query failed... ' . mysqli_error($conn);
}

mysqli_close($conn);
