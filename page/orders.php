<?php 
require '../functions.php';
session_start();

if(!isset($_SESSION['user'])){
    header('location: ../login.php');
}

if(isset($_COOKIE['user_email'])) {
    $data = $_COOKIE['user_email'];
}

if(isset($_GET['cancel'])) {
    $cancel_id = $_GET['cancel'];
    if(deleteRequest($cancel_id) > 0) {
        echo "Pesanan Berhasil dibatalkan";
    } else {
        echo "Pesanan Gagal dibatalkan";
    }
    header('location: orders.php');
}

$order = query("SELECT * FROM tb_order");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Page</title>

    <!-- Bootstrap 4.4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

</head>

<body>

    <h1>Halaman List Orders</h1>
    <a class="btn btn-secondary mb-5" href="../index.php">Home</a>

    <div class="d-flex flex-row">
        <?php $order = query("SELECT * FROM tb_order"); ?>
        <?php foreach( $order as $row ) : ?>
        <?php if(checkUser($data) == $row['id_user']) :?>
        <div class="card mx-4" style="width: 18rem;">
            <img class="card-img-top" src="https://via.placeholder.com/150" alt="">
            <div class="card-body">
                <p class="card-text">Order ID: <?= $row['id_order'] ?></p>
                <p class="card-text">Kuantitas: <?= $row['qty'] ?></p>
                <p class="card-text">Tipe Antar: <?= $row['tipe_antar'] ?></p>
                <p class="card-text">Status: <?= $row['status'] ?></p>
                <?php if($row['status'] == "Waiting") : ?>
                <a class="btn btn-primary" href="orders.php?cancel=<?=$row['id_order'] ?>"
                    onclick="return confirm('Hapus permintaan pesanan?');">Hapus permintaan</a>'
                <?php endif ?>
            </div>
        </div>

        <?php endif; ?>
        <?php endforeach; ?>

    </div>
</body>

</html>