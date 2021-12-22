<?php
require '../functions.php';
session_start();

if(checkCookie($_COOKIE) === true) {
    $_SESSION['user'] = $_COOKIE['user_email'];
}

if(isset($_SESSION['user'])){
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
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Login User</title>

        <!-- Font Family -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet" />

        <!-- CSS -->
        <link rel="stylesheet" href="../css/output.css?v=1" />

        <!-- JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>

        

    </head>
    <body class="bg-gray-soft">
        <form class="login-form" action="" method="POST">
            <img class="logo" src="../img/icons/oembah.svg" alt="Logo Oembah" />
            <a class="flex items-center space-x-2 text-gray-200 text-xs" href="../">
                <img class="w-4" src="../img/icons/arrow_left_icon.svg" alt="Arrow Icon" />
                <span class="hover:underline">Kembali</span>
            </a>
            <h1 class="text-white font-semibold text-xl text-center my-5">Login User</h1>
            <p>
                <?php echo $message ?>
            </p>
            <ul>
                <li>
                    <label class="label" for="email">Email</label>
                    <input id="email" name="email" class="form-input" type="email" placeholder="Email" />
                </li>
                <li>
                    <label class="label" for="password">Kata sandi</label>
                    <input id="password" name="password" class="form-input" type="password" placeholder="Password" />
                </li>
                <li>
                    <input class="rounded-full" type="checkbox" name="rememberme" id="rememberme" />
                    <label class="text-xs text-gray-200" for="rememberme">Simpan informasi masuk saya</label>
                </li>
            </ul>

            <div class="flex flex-col mt-10">
                <button class="btn-login mx-auto" name="login">Masuk</button>
                <div class="text-sm text-gray-200 mx-auto gap-x-2 gap-y-2 mt-4 flex items-center flex-col lg:flex-row">
                    <p class="">Belum punya akun?</p>
                    <a class="font-semibold underline hover:text-violet-500" href="./register.php">Daftar Sekarang</a>
                </div>
            </div>
        </form>
    </body>
</html>
