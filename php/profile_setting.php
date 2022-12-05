<?php
  $profile_page = $security_page = "";
  switch(@$_GET['page']){
    case 'profile':
      $profile_page = "active";
    break;
    case 'security':
      $security_page = "active";
    break;
    default:
      $profile_page = "active";
    break;
  }

?>
<section id="profile_top_title" class="about-us-area">
<div class="container">
  <div class="row align-items-center">
    <div class="col-12 col-lg-12">
      <div class="about-text mb-100">
        <div class="section-heading">
          <div class="line-"></div>
          <h2>Settings</h2>
        </div>
        <!-- Form Start -->
        <div class="row">
          <div class="col col-sm-4 col-md-3">
          <!-- <div class="card-header">  </div> -->
            <div class="card category-list-container booking-form p-2">
              <div class="list-group category-list">
                <tr>
                  <a href='profile_setting.php?page=profile' class='btn list-group-item list-group-item-action <?=$profile_page?>'>
                    <i class="fa fa-user"></i> Profile</a>
                  <a href='profile_setting.php?page=security' class='btn list-group-item list-group-item-action <?=$security_page?>'>
                    <i class="fa fa-lock"></i> Security</a>
                </tr>
              </div>
            </div>
          </div>
          <div class="col col-md-7">
            <?php if($profile_page == "active"){?>
            <form method="post" id="update_profile">
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
                <input type="hidden" name="user_id" id="user_id" value="<?=$_SESSION['id']?>"/>
                <div class="form-group ">
                    <label class="form-label" for="username">Username</label>
                    <input type="text" id="username" class="form-control" placeholder="Username" value="<?=$_SESSION['username']?>"/>
                </div>
                <div class="row ">
                    <div class="col">
                    <div class="form-group">
                        <label class="form-label" for="first_name">First name</label>
                        <input type="text" id="first_name" class="form-control"  placeholder="First name" value="<?=$_SESSION['first_name']?>"/>
                    </div>
                    </div>
                    <div class="col">
                    <div class="form-group">
                        <label class="form-label" for="last_name">Last name</label>
                        <input type="text" id="last_name" class="form-control"  placeholder="Last name" value="<?=$_SESSION['last_name']?>"/>
                    </div>
                    </div>
                </div>

                <div class="row ">
                    <div class="col">
                    <!-- Email input -->
                    <div class="form-group ">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" class="form-control disabled"  placeholder="Email" value="<?=$_SESSION['email']?>" readonly/>
                    </div>
                    </div>
                    <div class="col">

                    <!-- Number input -->
                    <div class="form-group ">
                        <label class="form-label" for="contact_no">Phone</label>
                        <input type="number" id="contact_no" class="form-control"  placeholder="09xxxxxxxx" value="<?=$_SESSION['contact_no']?>"/>
                    </div>
                    </div>
                </div>

                <!-- Text input -->
                <!-- <div class="form-group ">
                    <label class="form-label" for="form6Example4">Address</label>
                    <input type="text" id="form6Example4" class="form-control"  placeholder="Address" value="?=$_SESSION['username']?>"/>
                </div> -->

                <!-- Submit button -->
                <button type="submit" class="btn btn-branding btn-block">Update Profile</button>
            </form>
            <?php }else{ ?>
            <form method="post" id="update_security">
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
                <input type="hidden" name="user_id" id="user_id" value="<?=$_SESSION['id']?>"/>

                <div class="row ">
                    <div class="col">
                    <!-- Email input -->
                      <div class="form-group ">
                          <label class="form-label" for="current_password">Current Password</label>
                          <input type="password" id="current_password" class="form-control" placeholder="Current Password"/>
                      </div>
                    </div>
                    <div class="col">
                    <!-- Email input -->
                      <div class="form-group ">
                          <label class="form-label" for="password">New Password</label>
                          <input type="password" id="password" class="form-control" placeholder="New Password"/>
                      </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-branding btn-block">Update Password</button>
            </form>
          <!-- Form End -->
          <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
