<?php
    include("./controllers/db_con.php");
    
    $reserved_page = $_SERVER['REQUEST_URI'] == "/hotside-dev/reservation.php";
    $index_page = "index.php";
    $calendar_page = "#calendar_area";
    $about_us_page = "#about_us_area";
    $contact_page = "#contact_area";

    if($reserved_page){
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
    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Add the evo-calendar.css for styling -->
    <link rel="stylesheet" type="text/css" href="vendor/event-calendar-evo/evo-calendar/css/evo-calendar.css" />
    <link rel="stylesheet" type="text/css" href="vendor/event-calendar-evo/evo-calendar/css/evo-calendar.midnight-blue.css" />
</head>