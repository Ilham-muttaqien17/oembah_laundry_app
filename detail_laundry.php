<?php
require 'functions.php';
session_start();

if(!isset($_SESSION['user'])){
    header('location: login.php');
}

if(isset($_COOKIE['user_email'])){
    if(isset($_POST['order'])) {
    $email = $_COOKIE['user_email'];
    $id_laundry = $_GET['id'];
    $qty = $_POST['qty'];
    $tipe_antar = $_POST['tipe_antar'];

    $order = addOrder($email, $id_laundry, $qty, $tipe_antar);

    if($order > 0) {
        echo "<script>alert('Pesanan berhasil dibuat, silahkan tunggu konfirmasi!');
        document.location.href = index.php</script>";
    } else {
        echo "<script>alert('Pesanan gagal dibuat, mohon ulangi lagi!');
        document.location.href = detail_laundry.php</script>";
    }
    
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laundry</title>
</head>

<body>
    <h1>Halaman Detail Laundry</h1>

    <?php if(isset($_GET['id'])) : ?>
    <?php $laundry = getDetailLaundry($_GET['id']); ?>

    <p>Nama Laundry: <?= $laundry["nama_laundry"]; ?></p>
    <p>Email Laundry: <?= $laundry["email"]; ?></p>
    <p>Alamat Laundry: <?= $laundry["alamat"] ?></p>
    <p>Biaya: <?= $laundry["biaya"] ?></p>
    <p>Kontak: <?= $laundry["kontak"] ?></p>
    <p>Tipe: <?= $laundry["tipe_laundry"] ?></p>
    <p>Jam Buka: <?= $laundry["jam_buka"] ?></p>
    <p>Jam Tutup: <?= $laundry["jam_tutup"] ?></p>


    <form id="form_order" action="" method="POST">
        <label for="qty">Jumlah kuantitas: </label>
        <input name="qty" type="numeric" id="qty" required>
        <br>
        <label for="tipe_antar">Pilih tipe antar: </label>
        <select name="tipe_antar" id="tipe_antar" required>
            <option value="Pick up">Pick Up</option>
            <option value="Delivery">Delivery</option>
        </select>
        <button name="order">Pesan Sekarang</button>
    </form>

    <?php endif ?>

</body>

</html>