<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../config.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (!isset($_GET['token']) || !is_string($_GET['token']) || $_GET['token'] === '') {
    http_response_code(400);
    echo 'No token provided!';
    exit;
}

$token = $_GET['token'];

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Parameterized lookup (previously injectable via $_GET['token'])
    $stmt = $conn->prepare('SELECT user_id, username, email, verified FROM users WHERE token = ? LIMIT 1');
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($user === null) {
        http_response_code(404);
        echo 'User not found!';
        exit;
    }

    // Mark verified and revoke the token so the link can't be reused
    $stmt = $conn->prepare('UPDATE users SET verified = 1, token = NULL WHERE user_id = ? AND token = ?');
    $stmt->bind_param('is', $user['user_id'], $token);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    session_regenerate_id(true); // prevent session fixation

    $_SESSION['id'] = (int) $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['verified'] = true;
    $_SESSION['message'] = 'Your email address has been verified successfully';
    $_SESSION['type'] = 'alert-success';

    header('location: ../index.php');
    exit;
} catch (mysqli_sql_exception $e) {
    error_log('Email verification DB error: ' . $e->getMessage());
    http_response_code(500);
    echo 'Something went wrong. Please try again later.';
    exit;
}
