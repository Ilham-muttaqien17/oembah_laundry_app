<?php
require 'functions.php';
session_start();


if(checkCookie($_COOKIE) === true) {
    $_SESSION['login'] = true;
}

if(isset($_SESSION['login'])){
    header('location: index.php');
}

$message = '';

if(isset($_POST['login'])){
    if(!empty($_POST['email'])){
        if(!empty($_POST['password'])){
            if(loginUser($_POST) === false){
                $message = "Email atau password salah";
            }
        } else {
            $message = "Password tidak boleh kosong";
        }
    } else {
        $message = "Email tidak boleh kosong";
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User</title>
</head>
<h2>Login User</h2>
<p>
    <?php echo $message ?>
</p>
<form action="" method="POST">
    <label for="email">Email: </label>
    <input type="email" name="email" id="email" />
    <label for="password">Password: </label>
    <input type="password" name="password" id="password" />
    <button name="login">Login</button>
</form>

<a href="register.php">Registrasi sekarang</a>

<body>

</body>

</html>