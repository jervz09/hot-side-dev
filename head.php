<?php
    session_start();
    include("./controllers/db_con.php");
    include('session/checker.php');
    //setup for default value
    $reserved_disp = "";
    $reserved_page = $_SERVER['REQUEST_URI'] == "/hotside-dev/reserve.php";
    $index_page = "index.php";
    $calendar_page = "#calendar_area";
    $about_us_page = "#about_us_area";
    $contact_page = "#contact_area";

    if($reserved_page){
        $reserved_disp = 'style="visibility: hidden;"'; //Hide btn-reservation

        //redirect index(Landing Page)
        $index_page = "index.php";
        $calendar_page = "index.php#calendar_area";
        $about_us_page = "index.php#about_us_area";
        $contact_page = "index.php#contact_area";
    }
?>

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
    <!-- MDB -->
    <!-- <link rel="stylesheet" href="css/mdb.min.css" /> -->
    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Add the evo-calendar.css for styling -->
    <link rel="stylesheet" type="text/css" href="vendor/event-calendar-evo/evo-calendar/css/evo-calendar.css" />
    <link rel="stylesheet" type="text/css" href="vendor/event-calendar-evo/evo-calendar/css/evo-calendar.midnight-blue.css" />
    <!-- Datetime Picker -->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
    <!-- Alertify for notification -->
    <link rel="stylesheet" type="text/css" href="vendor/alertify/css/alertify.css" />
    <link rel="stylesheet" type="text/css" href="vendor/alertify/css/themes/bootstrap.css" />

    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
     <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.20.0/css/mdb.lite.min.css" integrity="sha512-Eu5EEZpsrO6niYlnhT+ITom/YVGoIZGEsbAvZ+gUJsO3Xaq9+hX4vZnbecMn/Cq5KOdmNOdehu/U80111W9xsA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="css/custom_style.css" />
</head>