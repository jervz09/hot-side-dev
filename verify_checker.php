<?php

declare(strict_types=1);

require_once __DIR__ . '/controllers/authController.php';

// Redirect to login if not authenticated
if (empty($_SESSION['id'])) {
    header('location: login.php');
    exit;
}

// Enforce email verification before using the app
if ($_SESSION['verified']) {
    header('location: index.php');
    exit;
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Handle "resend verification email" requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_verify()) {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $stmt = $conn->prepare('SELECT token FROM users WHERE user_id = ? LIMIT 1');
        $stmt->bind_param('i', $_SESSION['id']);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $conn->close();

        if ($row !== null && !empty($row['token'])) {
            if (sendVerificationEmail($_SESSION['email'], $row['token'])) {
                $_SESSION['message'] = 'Verification email sent! Please check your inbox.';
                $_SESSION['type'] = 'alert-success';
            } else {
                $_SESSION['message'] = 'Could not send the email. Please try again later.';
                $_SESSION['type'] = 'alert-danger';
            }
        }
    } catch (mysqli_sql_exception $e) {
        error_log('Resend verification error: ' . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <?php include 'head.php' ?>
  <body>
    <section class="vh-100">
      <div class="container">
        <div class="row">
          <div class="col-md-6 offset-md-3 my-5">

            <?php if (isset($_SESSION['message'])): ?>
            <div class="alert <?= htmlspecialchars((string) ($_SESSION['type'] ?? 'alert-info'), ENT_QUOTES, 'UTF-8') ?>">
              <?= htmlspecialchars((string) $_SESSION['message'], ENT_QUOTES, 'UTF-8') ?>
              <?php unset($_SESSION['message'], $_SESSION['type']); ?>
            </div>
            <?php endif; ?>

            <h4>Welcome, <?= htmlspecialchars((string) $_SESSION['username'], ENT_QUOTES, 'UTF-8') ?></h4>

            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              You need to verify your email address!
              Sign into your email account and click on the verification link we just emailed you at
              <strong><?= htmlspecialchars((string) $_SESSION['email'], ENT_QUOTES, 'UTF-8') ?></strong>
            </div>

            <form method="post" action="verify_checker.php">
              <?= csrf_field() ?>
              <button type="submit" class="btn btn-primary btn-block palatin-btn">Resend verification email</button>
            </form>

            <a href="logout.php" style="color: red">Logout</a>

          </div>
        </div>
      </div>
    </section>

    <?php include 'js_import.php' ?>
  </body>
</html>
