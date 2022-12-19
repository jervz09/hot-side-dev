<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
	include 'controllers/authController.php';
	include 'head_form.php';
?>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-sm my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form action="register.php" method="post" class="user">
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
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control form-control-user focus-brand"
                                            placeholder="Username">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="first_name" class="form-control form-control-user focus-brand"
                                            placeholder="First Name">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="last_name" class="form-control form-control-user focus-brand"
                                            placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-user focus-brand"
                                        placeholder="Email Address">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="contact_no" class="form-control form-control-user focus-brand"
                                        placeholder="Contact No">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password" class="form-control form-control-user"
                                            placeholder="Password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" name="passwordConf" class="form-control form-control-user"
                                            placeholder="Repeat Password">
                                    </div>
                                </div>
                                <button type="submit" name="signup-btn" class="btn btn-primary btn-user btn-block">Register Account</button>
                                <hr>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot_password.php">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>