<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
	include 'controllers/authController.php';
	include 'head_form.php';
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
										<h1 class="h4 text-gray-900">Forgot your password?</h1>
										<span class="small text-gray-700">Please check your email for a message with your code. </br>Your code is 6 numbers long.</span>
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

										<input type="hidden" name="email" value="<?=$_COOKIE["user_h_email"];?>"/>
										<div class="form-group">
											<div class="input-group mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text" id="email_code-addon1">Hotside - </span>
												</div>
												<input name="email_code" type="text" id="email_code"
												class="form-control form-control-user focus-brand" placeholder="Enter Code"
												minlength="6" maxlength="6" aria-describedby="email_code-addon1" required />
											</div>
										</div>
										<button type="submit" name="verifyforgotpassword-btn" class="btn btn-primary btn-user btn-block">Verify</button>
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