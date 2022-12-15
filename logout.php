<?php
session_start();
session_destroy();
unset($_SESSION['id']);
unset($_SESSION['username']);
unset($_SESSION['email']);
unset($_SESSION['verify']);
unset($_SESSION['for_logout']);
header("location: login.php");
?>