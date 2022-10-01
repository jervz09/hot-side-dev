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
                    <!-- <span class="h1 fw-bold mb-0">Logo</span> -->
                </div>

                <div class="col-sm-3">
                  <h3 class="form-name">Register</h3>
                </div>
            </div>

            <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 pt-xl-0 mt-xl-n5">
              <form action="register.php" method="post" autocomplete="OFF">

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
                  <input name="username" type="text" id="username" class="form-control form-control-lg" />
                  <label class="form-label" for="username">Username</label>
                </div>
                <div class="form-outline mb-4">
                  <input name="email" type="email" id="email" class="form-control form-control-lg" />
                  <label class="form-label" for="email">Email</label>
                </div>
                <div class="form-outline mb-4">
                  <input name="password" type="password" id="password" class="form-control form-control-lg" />
                  <label class="form-label" for="password">Password</label>
                </div>
                <div class="form-outline mb-4">
                  <input name="passwordConf" type="password" id="passwordConf" class="form-control form-control-lg" />
                  <label class="form-label" for="passwordConf">Confirm Password</label>
                </div>
                <div class="pt-1 mb-4">
                  <button type="submit" name="signup-btn" class="btn btn-lg btn-block palatin-btn">Register</button>
                </div>
                  <p>Already have an account? <a href="login.php">Login</a></p>
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