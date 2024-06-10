<?php
session_start();

// Destroy the session
session_destroy();

// Redirect the user to the login page
header("location: login.php");
exit();
?>