<?php
  include 'controllers/authController.php';
?>
<!DOCTYPE html>
<html lang="en">
  <?php include('head.php')?>

  <link rel="stylesheet" href="css/login_style.css">
  <body>
    <!-- Preloader Start -->
    <?php include('php/preloader.php')?>
    <!-- Preloader End -->
    <section class="vh-100">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6 text-black font-cursive">

          <div class="row">
                <div class="col-sm-3">
                  <img class="small-logo" src="img/core-img/black-logo.png" alt="" width="80px">
                </div>

                <div class="col-sm-3">
                  <h3 class="form-name">Log in</h3>
                </div>
            </div>

            <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 pt-xl-0 mt-xl-n5">
              <form action="login.php" method="post" autocomplete="OFF">
              <!-- Display if exists error. or  other msg alert-->
              <?php if (count($errors) > 0): ?>
                <div class="alert alert-danger error-message">
                  <?php foreach ($errors as $error): ?>
                  <li>
                    <?php echo $error; ?>
                  </li>
                  <?php endforeach;?>
                </div>
              <?php endif;?>
                <div class="form-outline mb-4">
                  <input name="username" type="email" id="email" class="form-control form-control-lg" required />
                  <label class="form-label" for="email">Email address</label>
                </div>
                <div class="form-outline mb-4">
                  <input name="password" type="password" id="password" class="form-control form-control-lg" required/>
                  <label class="form-label" for="password">Password</label>
                </div>
                <div class="pt-1 mb-4">
                  <button type="submit" name="login-btn" class="btn btn-lg btn-block palatin-btn">Login</button>
                </div>
                <p class="small mb-5 pb-lg-2">
                  <a class="text-muted" href="#!">Forgot password?</a>
                </p>
                <p>Don't have an account? <a href="register.php" class="link-info">Register here</a>
                </p>
              </form>
            </div>
          </div>
          <div class="col-sm-6 px-0 d-none d-sm-block">
            <img src="img/blog-img/3.jpg" alt="Login image" class="w-100 vh-100 bg-image-left-sticky" />
          </div>
        </div>
      </div>
    </section>

    <?php include('js_import.php')?>
  </body>
</html>