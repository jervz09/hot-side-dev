<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
	include 'head_form.php';
	include 'controllers/authController.php';
	if(!isset($_GET['params'])){
		header('location: login.php');
	}
?>

<body class="bg-gradient-primary">

	<div class="container">

		<!-- Outer Row -->
		<div class="row justify-content-center">

			<div class="col-xl-10 col-lg-12 col-md-9">

				<div class="card o-hidden border-0 shadow-sm my-5">
					<div class="card-body p-0">
						<!-- Nested Row within Card Body -->
						<div class="row">
							<div class="col-lg-6">
								<div class="p-5">
									<div class="text-center mb-4">
										<h1 class="h4 text-gray-900">Reset Password</h1>
									</div>
									<form action="<?=$_SERVER['REQUEST_URI']?>" class="user" method="post" autocomplete="OFF">
									<!-- Display if exists error. or  other msg alert-->
									<?php if (count($errors) > 0): ?>
										<div class="alert alert-<?=$_alert['type']?> error-message">
										<?php foreach ($errors as $error): ?>
										<li>
											<?php echo $error; ?>
										</li>
										<?php endforeach;?>
										</div>
									<?php endif;?>

										<div class="form-group">
											<label class="form-label" for="username">New Password</label>
											<input name="new_password" type="password" id="new_password"
												class="form-control form-control-user focus-brand" required />
										<hr>
											<label class="form-label" for="username">Confirm Password</label>
											<input name="conf_password" type="password" id="conf_password"
												class="form-control form-control-user focus-brand" required />
										</div>
										<button type="submit" name="resetpassword-btn" id="resetpassword-btn" class="btn btn-primary btn-user btn-block">Reset Password</button>
										<hr>
									</form>
									<hr>
									<div class="text-center">
										<a class="small" href="login.php">Already have an account? Login!</a>
									</div>
									<div class="text-center">
										<a class="small" href="register.php">Create an Account!</a>
									</div>
								</div>
							</div>

							<div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
						</div>
					</div>
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