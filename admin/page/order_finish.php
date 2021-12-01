<?php 
require '../functions.php';

session_start();

if(!isset($_SESSION['admin'])){
    header('location: ../login.php');
}
$data = '';

if(isset($_COOKIE['admin_email'])) {
    $data = $_COOKIE['admin_email'];
} else {
    setcookie('admin_email', '', time() - 3600);
    unset($_SESSION['admin']);
    header('location: ../login.php');
}

$order = query("SELECT * FROM tb_order"); 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>On Delivery Page</title>

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
    <h1>Halaman List On Delivery</h1>
    <a class="btn btn-secondary mb-5" href="../index.php">Home</a>

    <?php $i = 0 ?>
    <?php foreach(array_reverse($order) as $row) : ?>
    <?php if(checkUser($data) == $row['id_laundry']) :?>
    <?php if($row['status'] == 'Delivered') : ?>
    <div class="card my-4 w-25">
        <p>Order ID: <?= $row['id_order'] ?></p>
        <?php $userName = getUserName($row['id_user'])?>
        <p>Nama Pelanggan: <?= $userName ?></p>
        <p>Kuantitas: <?= $row['qty'] ?></p>
        <p>Tipe Antar: <?= $row['tipe_antar'] ?></p>
        <?php
            $contactUser = getContactUser($row['id_user']); 
            echo '<a href="https://wa.me/'. $contactUser. '">Chat User</a>';
        ?>
    </div>
    <?php $i++; ?>
    <?php endif ?>
    <?php endif ?>
    <?php endforeach ?>

    <?php
    global $i;
   
        if($i <= 0){
            echo "<p>Tidak ada pesanan yang selesai</p>";
        } else {
            echo "<p>Terdapat $i pesanan yang selesai</p>";
        }
    
    ?>
</body>

</html>