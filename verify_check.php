<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
	include 'controllers/authController.php';
	include 'head_form.php';

	// sendVerificationEmail($_SESSION["email"], $otp);
?>
<link rel="stylesheet/less" type="text/css" href="./css/verify_checker.less" />
<body class="bg-gradient-primary">

	<div class="container">

		<!-- Outer Row -->
		<div class="row justify-content-center">

			<div class="col-xl-10 col-lg-12 col-md-9">

				<div class="card o-hidden border-0 shadow-sm my-5">
					<div class="card-body p-0">
						<div class="row">
							<div class="col-lg-6">
								<div class="p-5" style="padding-bottom:0">
									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-4"></h1>
									</div>
									<form action="verify_check.php" class="user" method="post" autocomplete="OFF">

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

										<div id="wrapper">
											<div id="dialog">
												<h3>Please enter the 6-digit verification code we sent via Email:</h3>
												<span>We want to make sure it's really you. In order to further verify you
													identity, enter the verification code that was sent to <?=hintEmail($_SESSION['email'])?></span>
												<div id="form">
													<input type="text" class="digit" name="dig-1" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" onkeypress="return isNumber(event)" required />
													<input type="text" class="digit" name="dig-2" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" onkeypress="return isNumber(event)" required />
													<input type="text" class="digit" name="dig-3" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" onkeypress="return isNumber(event)" required />
													<input type="text" class="digit" name="dig-4" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" onkeypress="return isNumber(event)" required />
													<input type="text" class="digit" name="dig-5" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" onkeypress="return isNumber(event)" required />
													<input type="text" class="digit" name="dig-6" maxLength="1" size="1" min="0" max="9" pattern="[0-9]{1}" onkeypress="return isNumber(event)" required />
													<button name="verify-btn" class="btn btn-primary btn-embossed">Verify</button>
												</div>

												<div>
												</div>
											</div>
										</div>
									</form>
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
	<!-- <script src="./js/hotside-admin-2.min.js"></script> -->
	<script src="https://cdn.jsdelivr.net/npm/less" ></script>
	<script>
		function isNumber(evt) {
			evt = (evt) ? evt : window.event;
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode > 31 && (charCode < 48 || charCode > 57)) {
				return false;
			}
			return true;
		}
		$(".digit").keyup(function () {
			if (this.value.length == this.maxLength) {
				$(this).next('.digit').focus();
			}
		});
	</script>
</body>

</html>