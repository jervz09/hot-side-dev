<?php
// redirect user to login page if they're not logged in
if (empty($_SESSION['id']) &&
    $_SERVER['REQUEST_URI'] != "/hotside-dev/login.php" &&
    $_SERVER['REQUEST_URI'] != "/hotside-dev/register.php" &&
    $_SERVER['REQUEST_URI'] != "/hotside-dev/index.php") {
    header('location: login.php');
}
?>