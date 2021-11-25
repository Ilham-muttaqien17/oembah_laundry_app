<?php 
require 'functions.php';

session_start();

if(!isset($_SESSION['login'])){
    header('location: login.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn-tailwindcss.vercel.app"></script>
    <style type="text/tailwindcss">
        body {
            @apply m-0 p-0;
        }

        .card_laundry {
            @apply bg-gray-500 p-5 flex items-center my-5 space-x-3;
        }
        .btn_detail {
            @apply bg-blue-400 px-4 py-2;
        }
    </style>

</head>

<body>
    <h1>Welcome to Dashboard</h1>
    <a href="logout.php">Logout</a>

    <div class="grid gap-4 grid-cols-3">
        <?php $laundry = query("SELECT * FROM tb_laundry"); ?>
        <?php foreach( $laundry as $row ) : ?>
        <div class="card_laundry" onclick="">
            <img src="https://via.placeholder.com/150" alt="">
            <div>
                <p>Nama Laundry: <?= $row['nama_laundry']; ?></p>
                <p>Tipe Laundry: <?= $row['tipe_laundry']; ?></p>
                <p>Alamat Laundry: <?= $row['alamat']; ?></p>
                <a class="btn_detail" href="detail_laundry.php?id=<?php echo $row['id_laundry']; ?>">Detail</a>

            </div>
        </div>

        <?php endforeach;?>
    </div>



</body>

</html>