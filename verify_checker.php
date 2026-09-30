<?php
  session_start();
  include 'controllers/authController.php';
  include('session/checker.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="./css/bootstrap.min.css" />
  <link rel="stylesheet" href="main.css">
  <title>User verification system PHP</title>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-4 offset-md-4 home-wrapper">

        <!-- Display messages -->
        <?php if (isset($_SESSION['message'])): ?>
        <div class="alert <?= htmlspecialchars((string) ($_SESSION['type'] ?? 'alert-info'), ENT_QUOTES, 'UTF-8') ?>">
          <?= htmlspecialchars((string) $_SESSION['message'], ENT_QUOTES, 'UTF-8') ?>
          <?php unset($_SESSION['message'], $_SESSION['type']); ?>
        </div>
        <?php endif;?>

        <h4>Welcome, <?= htmlspecialchars((string) ($_SESSION['username'] ?? ''), ENT_QUOTES, 'UTF-8') ?></h4>
        <a href="logout.php" style="color: red">Logout</a>
        <?php if (empty($_SESSION['verified'])): ?>
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            You need to verify your email address!
            Sign into your email account and click
            on the verification link we just emailed you
            at
            <strong><?= htmlspecialchars((string) ($_SESSION['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?></strong>
          </div>
        <?php else: ?>
          <button class="btn btn-lg btn-primary btn-block">I'm verified!!!</button>
        <?php endif;?>
      </div>
    </div>
  </div>
</body>
</html>