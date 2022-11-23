<header class="header-area" id="header_area">
  <!-- Navbar Area -->
  <div class="palatin-main-menu">
    <div class="classy-nav-container breakpoint-off">
      <div class="container">
        <!-- Menu -->
        <nav class="classy-navbar justify-content-between" id="palatinNav">
          <!-- Nav brand -->
          <a href="index.php" class="nav-brand">
            <img src="img/core-img/logo.png" alt="" style="
                        width: 70px;
                        margin: 0px 0px 0px 5px;
                    ">
          </a>
          <!-- Navbar Toggler -->
          <div class="classy-navbar-toggler">
            <span class="navbarToggler">
              <span></span>
              <span></span>
              <span></span>
            </span>
          </div>
          <!-- Menu -->
          <div class="classy-menu">
            <!-- close btn -->
            <div class="classycloseIcon">
              <div class="cross-wrap">
                <span class="top"></span>
                <span class="bottom"></span>
              </div>
            </div>
            <!-- Nav Start -->
            <div class="classynav">
              <ul>
                <li>
                  <a href="<?php echo $index_page;?>">Home</a>
                </li>
                <li>
                  <a href="<?php echo $calendar_page;?>">Calendar</a>
                </li>
                <li>
                  <a href="<?php echo $about_us_page;?>">About Us</a>
                </li>
                <li>
                  <a href="<?php echo $contact_page;?>">Contact</a>
                </li>
              </ul>
              <!-- Button -->
              <div class="menu-btn">
                <!-- <a href="#calendar" class="btn palatin-btn" data-toggle="modal" data-target="#reservation_modal">Make a Reservation</a> -->
                <a href="register.php" class="btn palatin-btn" <?=$signed_user?>>Register</a>
                <a href="login.php" class="btn palatin-btn" <?=$signed_user?>>Login</a>
                <div class="dropdown" <?=$not_signed_user?>>
                  <!-- <a href="#" class="btn palatin-btn"><i class="fa fa-user"></i> Hotside User</a> -->
                  <button class="btn palatin-btn dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="top: -25px;">
                    <i class="fa fa-user"></i> <?= $_SESSION['username']?>
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item text-secondary" href="#">Profile Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-secondary" href="#">Logout</a>
                  </div>
                </div>
              </div>
            </div>
            <!-- Nav End -->
          </div>
        </nav>
      </div>
    </div>
  </div>
</header>