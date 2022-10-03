<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Hot Side</title>

    <!-- Favicon -->
    <link rel="icon" href="img/favicon.ico">

    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Add the evo-calendar.css for styling -->
    <link rel="stylesheet" type="text/css" href="vendor/event-calendar-evo/evo-calendar/css/evo-calendar.css"/>
    <link rel="stylesheet" type="text/css" href="vendor/event-calendar-evo/evo-calendar/css/evo-calendar.midnight-blue.css"/>

</head>

<body>
    <!-- Preloader -->
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="cssload-container">
            <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
        </div>
    </div>

    <!-- ##### Header Area Start ##### -->
    <header class="header-area">
        <!-- Navbar Area -->
        <div class="palatin-main-menu">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <!-- Menu -->
                    <nav class="classy-navbar justify-content-between" id="palatinNav">

                        <!-- Nav brand -->
                        <a href="index.html" class="nav-brand"><img src="img/core-img/logo.png" alt="" style="
                            width: 80px;
                            margin: 0px 0px 0px 65px;
                        "></a>

                        <!-- Navbar Toggler -->
                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler"><span></span><span></span><span></span></span>
                        </div>

                        <!-- Menu -->
                        <div class="classy-menu">

                            <!-- close btn -->
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>

                            <!-- Nav Start -->
                            <div class="classynav">
                                <ul>
                                    <li><a href="index.html">Home</a></li>
                                    <li><a href="#calendar_area">Calendar</a></li>
                                    <li><a href="#about_us_area">About Us</a></li>
                                    <li><a href="#contact_area">Contact</a></li>
                                </ul>

                                <!-- Button -->
                                <div class="menu-btn">
                                    <a href="reservation.html" class="btn palatin-btn">Make a Reservation</a>
                                </div>

                            </div>
                            <!-- Nav End -->
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->

    <!-- ##### Calendar Area Start ##### -->
    <section id="calendar_area" class="about-us-area" style="padding-top: 160px;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-12">
                    <div class="calendar_container mb-80">
                        <div class="section-heading mb-20">
                            <div class="line-"></div>
                            <h2>Calendar</h2>
                        </div>
                        <div id="calendar"></div>
                        <!-- <a href="reservation.html" class="btn palatin-btn mb-40">Make a Reservation</a> -->
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- ##### Calendar Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer-area mt-20" style="margin-top: 20px">
        <div class="container">
            <div class="row">

                <!-- Footer Widget Area -->
                <div class="col-12 col-lg-6">
                    <div class="footer-widget-area mt-50">
                        <a href="#" class="d-block mb-5"><img src="img/core-img/logo.png" alt="" style="width: 105px;"></a>
                        <p>Hot Side Resto and Bar is an upscale yet affordable Asian restaurant and bar. Hot Side serves wide.</p>
                    </div>
                </div>

                <!-- Footer Widget Area -->
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="footer-widget-area mt-50">
                        <h6 class="widget-title mb-5">Find us on the map</h6>
                        <img src="img/bg-img/footer-map.png" alt="">
                    </div>
                </div>

                <!-- Footer Widget Area -->
                <!-- <div class="col-12 col-md-6 col-lg-3">
                    <div class="footer-widget-area mt-50">
                        <h6 class="widget-title mb-5">Subscribe to our newsletter</h6>
                        <form action="#" method="post" class="subscribe-form">
                            <input type="email" name="subscribe-email" id="subscribeemail" placeholder="Your E-mail">
                            <button type="submit">Subscribe</button>
                        </form>
                    </div>
                </div> -->

                <!-- Copywrite Text -->
                <div class="col-12">
                    <div class="copywrite-text mt-30">
                        <p><a href="#"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ##### Footer Area End ##### -->


    <!-- ##### All Javascript Script ##### -->
    <!-- jQuery-2.2.4 js -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="js/bootstrap/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <!-- All Plugins js -->
    <script src="js/plugins/plugins.js"></script>
    <!-- Active js -->
    <script src="js/active.js"></script>
    <!-- Add jQuery library (required) -->

    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script> -->

    <!-- Add the evo-calendar.js for.. obviously, functionality! -->
    <script src="vendor/event-calendar-evo/evo-calendar/js/evo-calendar.js"></script>

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        $("#calendar").evoCalendar({
            theme: 'Midnight Blue'
        });
    </script>
</body>

</html>