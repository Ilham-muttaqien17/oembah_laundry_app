<?php 
require 'functions.php';

if(isset($_POST['register'])){

    // check if the data was successfully added or not
    if(registerLaundry($_POST) > 0){
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
    <h2>Registrasi Laundry</h2>
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
                <label for="alamat">Alamat: </label>
                <input type="text" name="alamat" id="alamat" required>
            </li>
            <li>
                <label for="biaya">Biaya: </label>
                <input type="number" min="0.00" name="biaya" id="biaya" required>
            </li>
            <li>
                <label for="kontak">Kontak: </label>
                <input type="text" name="kontak" id="kontak" required>
            </li>
            <li>
                <label for="jenis">Pilih jenis laundry</label>
                <select name="jenis" id="jenis" name="jenis" required>
                    <option value="Kiloan">Kiloan</option>
                    <option value="Sepatu">Sepatu</option>
                    <option value="Helm">Helm</option>
                </select>
            </li>
            <li>
                <label for="open_time">Jam Buka: </label>
                <input type="time" name="open_time" id="open_time" required>
            </li>
            <li>
                <label for="close_time">Jam Buka: </label>
                <input type="time" name="close_time" id="close_time" required>
            </li>
            <li>
                <button name="register">Daftar Sekarang</button>
            </li>
        </ul>

    </form>

    <a href="login.php">Login</a>

</body>

</html>