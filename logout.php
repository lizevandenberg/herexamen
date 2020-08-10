<?php
session_start();
session_destroy();
unset($_SESSION['username']);
$_SESSION['message']="Je bent uitgelogd";
header("location:login.php");
?>