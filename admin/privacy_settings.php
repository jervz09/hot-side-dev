<style>
    *{
        font-size: 14px;
    },
    input.form-control.form-control-user.focus-brand {
        font-size: 14px;
    }
</style>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">Privacy Settings</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-9">
                    <div class="p-5">
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
                    </div>
                </div>
        </div>
    </div>

</div>