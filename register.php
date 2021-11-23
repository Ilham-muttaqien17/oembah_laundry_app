<?php 
require 'functions.php';

if(isset($_POST['register'])){

    // check if the data was successfully added or not
    if(registerUser($_POST) > 0){
        echo "<script>
        alert('Berhasil mendaftarkan akun!'); 
        document.location.href = 'login.php'
        </script>";
    } else {
        echo "<script>
        alert('Gagal mendaftarkan akun!'); 
        document.location.href = 'login.php';
        </script>";
        echo mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regitrasi User</title>
</head>

<body>
    <h2>Resgistrasi User Baru</h2>
    <form action="" method="POST">
        <ul>
            <li>
                <label for="name">Nama: </label>
                <input type="text" name="name" id="name" required>
            </li>
            <li>
                <label for="email">Email: </label>
                <input type="text" name="email" id="email" required>
            </li>
            <li>
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" required>
            </li>
            <li>
                <label for="confirm">Konfirmasi Password: </label>
                <input type="password" name="confirm" id="confirm" required>
            </li>
            <li>
                <button name="register">Daftar Sekarang</button>
            </li>
        </ul>

    </form>

    <a href="login.php">Login</a>

</body>

</html>