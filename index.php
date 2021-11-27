<?php 
require 'functions.php';

session_start();

if(!isset($_SESSION['user'])){
    header('location: login.php');
}

if(!isset($_COOKIE['user_email'])) {
    setcookie('user_email', '', time() - 3600);
    unset($_SESSION['user']);
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
    <h1>Welcome to Dashboard</h1>
    <div>
        <a class="btn btn-secondary" href="page/orders.php">Orders</a>
        <a class="btn btn-secondary" href="page/history_order.php">History</a>
        <a class="btn btn-secondary" href="#">Notification</a>
    </div>

    <a href="logout.php">Logout</a>

    <div class="d-flex flex-row">
        <?php $laundry = query("SELECT * FROM tb_laundry"); ?>
        <?php foreach( $laundry as $row ) : ?>
        <div class="card mx-4" style="width: 18rem;">
            <img class="card-img-top" src="https://via.placeholder.com/150" alt="">
            <div class="card-body">
                <p class="card-text">Nama Laundry: <?= $row['nama_laundry']; ?></p>
                <p class="card-text">Tipe Laundry: <?= $row['tipe_laundry']; ?></p>
                <p class="card-text">Alamat Laundry: <?= $row['alamat']; ?></p>
                <a class="btn btn-primary" href="detail_laundry.php?id=<?php echo $row['id_laundry']; ?>">Detail</a>

            </div>
        </div>

        <?php endforeach;?>
    </div>



</body>

</html>