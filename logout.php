<?php 

session_start();
unset($_SESSION['user']);
// session_destroy();
setcookie('user_email', '', time() - 3600);
header('location: login.php');

?>