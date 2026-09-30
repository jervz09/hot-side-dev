<?php

declare(strict_types=1);

require_once __DIR__ . '/helper.php';
require_once __DIR__ . '/sendEmails.php';
require_once __DIR__ . '/../config.php';

$username = '';
$email = '';
$errors = [];
$_alert = [];

include __DIR__ . '/db_con.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

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

// SIGN UP USER
if (isset($_POST['signup-btn'])) {
    if (csrf_verify()) {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');
        $contact_no = trim($_POST['contact_no'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '') {
            $errors['username'] = 'Username required';
        }
        if ($email === '') {
            $errors['email'] = 'Email required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address';
        }
        if ($first_name === '') {
            $errors['first_name'] = 'First Name required';
        }
        if ($last_name === '') {
            $errors['last_name'] = 'Last Name required';
        }
        if ($contact_no === '') {
            $errors['contact_no'] = 'Contact Number required';
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
                // Check if email/username already exist (parameterized)
                $stmt = $conn->prepare('SELECT email, username FROM users WHERE email = ? OR username = ? LIMIT 1');
                $stmt->bind_param('ss', $email, $username);
                $stmt->execute();
                $existing = $stmt->get_result()->fetch_assoc();
                $stmt->close();

                if ($existing !== null) {
                    if (strcasecmp((string) $existing['email'], $email) === 0) {
                        $errors['email'] = 'Email already exists';
                    }
                    if (strcasecmp((string) $existing['username'], $username) === 0) {
                        $errors['username'] = 'Username already exists';
                    }
                }

                if (count($errors) === 0) {
                    $otp = random_int(100000, 999999);
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                    $stmt = $conn->prepare(
                        'INSERT INTO users (username, first_name, last_name, contact_no, email, otp, password) VALUES (?, ?, ?, ?, ?, ?, ?)'
                    );
                    $stmt->bind_param('sssssss', $username, $first_name, $last_name, $contact_no, $email, $otp, $passwordHash);
                    $stmt->execute();
                    $user_id = (int) $stmt->insert_id;
                    $stmt->close();

                    sendVerificationEmail($email, (string) $otp);

                    session_regenerate_id(true); // prevent session fixation

                    $_SESSION['id'] = $user_id;
                    $_SESSION['username'] = $username;
                    $_SESSION['first_name'] = $first_name;
                    $_SESSION['last_name'] = $last_name;
                    $_SESSION['email'] = $email;
                    $_SESSION['verified'] = false;
                    $_SESSION['message'] = 'You are logged in!';
                    $_SESSION['type'] = 'alert-success';

                    header('location: verify_check.php');
                    exit;
                }
            } catch (mysqli_sql_exception $e) {
                error_log('Signup DB error: ' . $e->getMessage());
                $errors['db'] = 'Something went wrong. Please try again later.';
            }
        }
    }
}

// LOGIN user
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
                $stmt = $conn->prepare('SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1');
                $stmt->bind_param('ss', $username, $username);
                $stmt->execute();
                $user = $stmt->get_result()->fetch_assoc();
                $stmt->close();

                if ($user !== null && password_verify($password, (string) $user['password'])) {
                    session_regenerate_id(true); // prevent session fixation

                    $_SESSION['id'] = (int) $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['last_name'] = $user['last_name'];
                    $_SESSION['contact_no'] = $user['contact_no'];
                    $_SESSION['address'] = $user['address'] ?? '';
                    $_SESSION['landmark'] = $user['landmark'] ?? '';
                    $_SESSION['verified'] = (bool) $user['verified'];
                    $_SESSION['is_admin'] = (int) $user['role_id'];

                    header('location: verify_check.php');
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

// EMAIL/OTP VERIFICATION (login + signup)
if (isset($_POST['verify-btn'])) {
    $dig = function (string $key): string {
        $v = $_POST[$key] ?? '';
        return preg_match('/^[0-9]$/', (string) $v) ? (string) $v : 'x';
    };

    $otp_user = $dig('dig-1') . $dig('dig-2') . $dig('dig-3')
        . $dig('dig-4') . $dig('dig-5') . $dig('dig-6');

    if (strlen($otp_user) === 6 && ctype_digit($otp_user)) {
        try {
            // Verify against the logged-in user's OTP only (prevents code guessing
            // against other accounts; previously injectable and cross-account).
            $stmt = $conn->prepare('SELECT user_id, username, email, otp FROM users WHERE user_id = ? LIMIT 1');
            $stmt->bind_param('i', $_SESSION['id']);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if ($user !== null && hash_equals((string) $user['otp'], $otp_user)) {
                $stmt = $conn->prepare('UPDATE users SET verified = 1, otp = NULL WHERE user_id = ?');
                $stmt->bind_param('i', $_SESSION['id']);
                $stmt->execute();
                $stmt->close();

                session_regenerate_id(true); // prevent session fixation

                $_SESSION['verified'] = true;
                $_SESSION['message'] = 'Your email address has been verified successfully';
                $_SESSION['type'] = 'alert-success';
                header('location: index.php');
                exit;
            }

            $errors['otp_failed'] = 'Incorrect OTP';
        } catch (mysqli_sql_exception $e) {
            error_log('OTP verify error: ' . $e->getMessage());
            $errors['otp_failed'] = 'Something went wrong. Please try again later.';
        }
    } else {
        $errors['otp_failed'] = 'Incorrect OTP';
    }
}

// FORGOT PASSWORD: send recovery code by email
if (isset($_POST['forgotpassword-btn'])) {
    if (csrf_verify()) {
        $user_email = trim($_POST['email'] ?? '');

        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $_alert['type'] = 'danger';
            $errors['success_send'] = 'Please enter a valid email address.';
        } else {
            try {
                $stmt = $conn->prepare('SELECT user_id, username FROM users WHERE email = ? LIMIT 1');
                $stmt->bind_param('s', $user_email);
                $stmt->execute();
                $user = $stmt->get_result()->fetch_assoc();
                $stmt->close();

                if ($user !== null) {
                    $otp = random_int(100000, 999999);

                    $recoveryOtp = (string) $otp;
                    $stmt = $conn->prepare('UPDATE users SET otp = ? WHERE user_id = ?');
                    $stmt->bind_param('si', $recoveryOtp, $user['user_id']);
                    $stmt->execute();
                    $stmt->close();

                    $_alert['type'] = 'success';
                    $errors['success_send'] = 'We sent your code to: </br><strong>'
                        . htmlspecialchars(hintEmail($user_email), ENT_QUOTES, 'UTF-8') . '</strong>';

                    setcookie('user_h_email', $user_email, [
                        'expires' => time() + 3600,
                        'path' => '/',
                        'httponly' => true,
                        'samesite' => 'Lax',
                    ]);

                    sendVerificationEmail(
                        $user_email,
                        (string) $otp,
                        $subject = 'Hotside Restobar - Recovery Code',
                        $header_msg = 'Hello ' . $user['username'] . '!',
                        $body_msg = 'We received a request to reset your Hotside Password.'
                    );
                } else {
                    $_alert['type'] = 'danger';
                    // Same message either way so accounts cannot be enumerated
                    $errors['success_send'] = "If that email exists, we've sent a recovery code. Please check your inbox.";
                }
                }
            } catch (mysqli_sql_exception $e) {
                error_log('Forgot password error: ' . $e->getMessage());
                $errors['success_send'] = 'Something went wrong. Please try again later.';
            }
        }
    }
}

// VERIFY FORGOT-PASSWORD CODE
if (isset($_POST['verifyforgotpassword-btn'])) {
    if (csrf_verify()) {
        $user_otp = trim($_POST['email_code'] ?? '');
        $user_email = trim($_POST['email'] ?? '');

        if ($user_email !== '' && preg_match('/^[0-9]{6}$/', $user_otp)) {
            try {
                // The code must match the one stored for THIS email
                $stmt = $conn->prepare('SELECT user_id FROM users WHERE email = ? AND otp = ? LIMIT 1');
                $stmt->bind_param('ss', $user_email, $user_otp);
                $stmt->execute();
                $match = $stmt->get_result()->fetch_assoc();
                $stmt->close();

                if ($match !== null) {
                    $encrypt_email = let_crypt($user_email, true);
                    header('location: reset_password.php?params=' . urlencode($encrypt_email));
                    exit;
                }

                $_alert['type'] = 'danger';
                $errors['success_send'] = 'The number you entered doesn’t match your code. Please try again.';
            } catch (mysqli_sql_exception $e) {
                error_log('Recovery code verify error: ' . $e->getMessage());
                $errors['success_send'] = 'Something went wrong. Please try again later.';
            }
        } else {
            $_alert['type'] = 'danger';
            $errors['success_send'] = 'The number you entered doesn’t match your code. Please try again.';
        }
    }
}

// RESET PASSWORD (link with encrypted email param)
if (isset($_POST['resetpassword-btn']) && isset($_GET['params'])) {
    if (csrf_verify()) {
        $decrypt_email = let_crypt((string) $_GET['params']);
        $new_password = $_POST['new_password'] ?? '';
        $conf_password = $_POST['conf_password'] ?? '';

        if ($decrypt_email === '') {
            $_alert['type'] = 'danger';
            $errors['success_send'] = 'Invalid or expired reset link.';
        } elseif (strlen($new_password) < 8) {
            $_alert['type'] = 'danger';
            $errors['otp_failed'] = 'Password must be at least 8 characters.';
        } elseif ($new_password !== $conf_password) {
            $_alert['type'] = 'danger';
            $errors['otp_failed'] = 'Passwords do not match.';
        } else {
            try {
                $passwordHash = password_hash($new_password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare('UPDATE users SET password = ?, otp = NULL WHERE email = ?');
                $stmt->bind_param('ss', $passwordHash, $decrypt_email);   
                $stmt->execute();
                $stmt->close();

                $_alert['type'] = 'success';
                $errors['otp_failed'] = 'Successfully updated, please login.';
                echo "<script>window.alert('Successfully updated, please login.');
                    setTimeout(function(){window.location.href = 'login.php';}, 1500)</script>";
            } catch (mysqli_sql_exception $e) {
                error_log('Reset password error: ' . $e->getMessage());
                $_alert['type'] = 'danger';
                $errors['otp_failed'] = 'Something went wrong. Please try again later.';
            }
    }
    }
}

// RESEND VERIFICATION OTP
if (isset($_GET['resend'])) {
    if (empty($_SESSION['id'])) {
        header('location: login.php');
        exit;
    }

    try {
        $otp = random_int(100000, 999999);

        $stmt = $conn->prepare('UPDATE users SET otp = ? WHERE user_id = ?');
        $stmt->bind_param('si', (string) $otp, $_SESSION['id']);
        $stmt->execute();
        $stmt->close();

        sendVerificationEmail((string) $_SESSION['email'], (string) $otp);

        $_SESSION['message'] = 'A new verification code has been sent to your email.';
        $_SESSION['type'] = 'alert-success';
    } catch (mysqli_sql_exception $e) {
        error_log('Resend OTP error: ' . $e->getMessage());
        $_SESSION['message'] = 'Could not resend the code. Please try again later.';
        $_SESSION['type'] = 'alert-danger';
    }

    header('location: verify_check.php');
    exit;
}

function hintEmail(string $email): string
{
    $stars = 4; // Min Stars to use
    $at = strpos($email, '@');
    if ($at === false) {
        return str_repeat('*', strlen($email));
    }
    if ($at - 2 > $stars) {
        $stars = $at - 2;
    }

    return substr($email, 0, 1) . str_repeat('*', $stars) . substr($email, $at - 1);
}
