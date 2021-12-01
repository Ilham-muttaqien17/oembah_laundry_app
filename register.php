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
    <script type="text/javascript" src="js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7So2OFuOg3mJdwU2h2lkoFz19E5GGag8"></script>
</head>

<body onload="initialize()">
    <h2>Resgistrasi User Baru</h2>
    <form action="" method="POST">
        <ul>
            <li>
                <label for="name">Nama: </label>
                <input type="text" name="name" id="name" required>
            </li>
            <li>
                <label for="email">Email: </label>
                <input type="email" name="email" id="email" required>
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
                <label for="kontak">Kontak: </label>
                <input type="text" name="kontak" id="kontak" required>
            </li>
            <li>
                <span>Gunakan Map untuk Menentukan Alamat</span><br>
                <label for="alamat">Alamat: </label>
                <input type="text" name="alamat" id="alamat" readonly required>
                <label for="latitude">Latitude</label>
                <input type="text" name="latitude" id="latitude" readonly>
                <label for="longitude">Longitude</label>
                <input type="text" name="longitude" id="longitude" readonly>
                <div id="map_canvas" style="width: 50%; height: 400px"></div>

            </li>
            <li>
                <button name="register">Daftar Sekarang</button>
            </li>
        </ul>

    </form>

    <a href="login.php">Login</a>

</body>

</html>