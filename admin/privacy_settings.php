<style>
    *{
        font-size: 14px;
    },
    input.form-control.form-control-user.focus-brand {
        font-size: 14px;
    }
</style>
<?php include_once("./helper/privacy_settings.php") ?>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">Privacy Settings</h6>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="p-5">
                        <form action="" id="update_privacy_setting" method="post">
                            <!-- Display if exists error. or  other msg alert-->
                            <?php if (count($errors) > 0): ?>
                                <div class="alert <?=$_SESSION['type']?> error-message">
                                <?php foreach ($errors as $error): ?>
                                <li>
                                    <?php echo $error; ?>
                                </li>
                                <?php endforeach;?>
                                </div>
                            <?php endif;?>

                            <input type="hidden" name="user_id" value="<?=$_SESSION['id']?>">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label>Current Password <span class="text-danger">*</span></label>
                                    <input type="password" name="cpassword" class="form-control form-control-user"
                                        placeholder="Current Password" required>
                                </div>
                                <div class="col-sm-6">
                                    <label>Repeat Current Password <span class="text-danger">*</span></label>
                                    <input type="password" name="cpasswordConf" class="form-control form-control-user"
                                        placeholder="Repeat Current Password" required>
                                </div>
                            </div>
                            <hr>
                            <hr>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label>New Password <span class="text-danger">*</span></label>
                                    <input type="password" name="npassword" class="form-control form-control-user"
                                        placeholder="New Password" required>
                                </div>
                                <div class="col-sm-6">
                                    <label>Repeat New Password <span class="text-danger">*</span></label>
                                    <input type="password" name="npasswordConf" class="form-control form-control-user"
                                        placeholder="Repeat New Password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" name="logout_session" class="custom-control-input" id="customCheck">
                                    <label class="custom-control-label" style="font-size:10px"for="customCheck">Logout session.</label>
                                </div>
                            </div>
                            <hr>
                            <button type="submit" name="update_privacy_btn" class="btn btn-primary btn-user btn-block">Update Password</button>
                            <hr>
                        </form>
                    </div>
                </div>
        </div>
    </div>

</div>

<?php
    if($_SESSION['for_logout']){
        ?>
        <script>
            setTimeout(function(){window.location.href = "../logout.php";}, 1500)
        </script>
        <?php
    }
?>