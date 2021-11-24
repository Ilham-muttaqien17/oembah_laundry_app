<?php
require 'functions.php';
session_start();

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

    <?php endif ?>

</body>

</html>