<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/sendEmails.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$username = '';
$email = '';
$errors = [];

/** Get (or create) the CSRF token for this session. */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

/** Hidden input field carrying the CSRF token. */
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="'
        . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

/** Validate the submitted CSRF token; records an error and returns false on mismatch. */
function csrf_verify(): bool
{
    global $errors;

    $sent = $_POST['csrf_token'] ?? '';

    if (!is_string($sent) || !hash_equals(csrf_token(), $sent)) {
        $errors['csrf'] = 'Your session expired. Please try again.';

        return false;
    }

    return true;
}

function db_connect(): mysqli
{
    return new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}

// SIGN UP USER
if (isset($_POST['signup-btn'])) {
    if (csrf_verify()) {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '') {
            $errors['username'] = 'Username required';
        }
        if ($email === '') {
            $errors['email'] = 'Email required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address';
        }
        if ($password === '') {
            $errors['password'] = 'Password required';
        } elseif (strlen($password) < 8) {
            $errors['password'] = 'Password must be at least 8 characters';
        }
        if ($password !== ($_POST['passwordConf'] ?? '')) {
            $errors['passwordConf'] = 'The two passwords do not match';
        }

        if (count($errors) === 0) {
            try {
                $conn = db_connect();

                // Check if email already exists (parameterized)
                $stmt = $conn->prepare('SELECT user_id FROM users WHERE email = ? LIMIT 1');
                $stmt->bind_param('s', $email);
                $stmt->execute();

                if ($stmt->get_result()->num_rows > 0) {
                    $errors['email'] = 'Email already exists';
                }
                $stmt->close();

                if (count($errors) === 0) {
                    $token = bin2hex(random_bytes(32)); // unique verification token
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                    $stmt = $conn->prepare(
                        'INSERT INTO users (username, email, token, password, is_admin) VALUES (?, ?, ?, ?, 0)'
                    );
                    $stmt->bind_param('ssss', $username, $email, $token, $passwordHash);
                    $stmt->execute();
                    $user_id = (int) $stmt->insert_id;
                    $stmt->close();
                    $conn->close();

                    // Send verification email to user
                    sendVerificationEmail($email, $token);

                    session_regenerate_id(true); // prevent session fixation

                    $_SESSION['id'] = $user_id;
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $email;
                    $_SESSION['verified'] = false;
                    $_SESSION['message'] = 'You are logged in!';
                    $_SESSION['type'] = 'alert-success';

                    header('location: index.php');
                    exit;
                }

                $conn->close();
            } catch (mysqli_sql_exception $e) {
                error_log('Signup DB error: ' . $e->getMessage());
                $errors['db'] = 'Something went wrong. Please try again later.';
            }
        }
    }
}

// LOGIN
if (isset($_POST['login-btn'])) {
    if (csrf_verify()) {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '') {
            $errors['username'] = 'Username or email required';
        }
        if ($password === '') {
            $errors['password'] = 'Password required';
        }

        if (count($errors) === 0) {
            try {
                $conn = db_connect();

                $stmt = $conn->prepare('SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1');
                $stmt->bind_param('ss', $username, $username);
                $stmt->execute();
                $user = $stmt->get_result()->fetch_assoc();
                $stmt->close();
                $conn->close();

                if ($user !== null && password_verify($password, $user['password'])) {
                    session_regenerate_id(true); // prevent session fixation

                    $_SESSION['id'] = (int) $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['verified'] = (bool) $user['verified'];
                    $_SESSION['message'] = 'You are logged in!';
                    $_SESSION['type'] = 'alert-success';

                    header('location: verify_checker.php');
                    exit;
                }

                $errors['login_fail'] = 'Wrong username / password';
            } catch (mysqli_sql_exception $e) {
                error_log('Login DB error: ' . $e->getMessage());
                $errors['login_fail'] = 'Something went wrong. Please try again later.';
            }
        }
    }
}
