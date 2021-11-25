<?php 

session_start();
unset($_SESSION['admin']);
// session_destroy();
setcookie('admin_email', '', time() - 3600);
header('location: login.php');

?>