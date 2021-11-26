<?php 
require '../functions.php';
session_start();

if(!isset($_SESSION['admin'])){
    header('location: ../login.php');
}

if(isset($_COOKIE['admin_email'])) {
    $data = $_COOKIE['admin_email'];
}

$order = query("SELECT * FROM tb_order");

if(isset($_GET['id'])){

    if(sendOrderIn($_GET['id']) > 0) {
        // echo "<script>alert('Pesanan berhasil dikonfirmasi!');</script>";
        $message = '<div class="alert alert-primary" role="alert">Pesanan berhasil dikonfirmasi</div>';
        
    } else {
        $message = '<div class="alert alert-primary" role="alert">Pesanan gagal dikonfirmasi</div>';
    }
    header('location: send_order.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Order Page</title>
</head>

<body>
    <h1>Halaman List Send Order</h1>
    <a class="btn btn-secondary mb-5" href="../index.php">Home</a>


    <?php $i = 0 ?>
    <?php foreach($order as $row) : ?>
    <?php if(checkUser($data) == $row['id_laundry']) :?>
    <?php if($row['status'] == 'On Process') : ?>
    <div class="card my-4 w-25">
        <p>Order ID: <?= $row['id_order'] ?></p>
        <p>Kuantitas: <?= $row['qty'] ?></p>
        <p>Tipe Antar: <?= $row['tipe_antar'] ?></p>
        <p>User Id: <?= $row['id_user'] ?></p>
        <a href="send_order.php?id=<?= $row['id_order']; ?>" onclick="return confirm('Kirim pesanan?');"
            class="btn btn-primary">Kirim Pesanan</a>
    </div>
    <?php $i++; ?>
    <?php endif ?>
    <?php endif ?>
    <?php endforeach ?>

    <?php
    global $i;
   
        if($i <= 0){
            echo "<p>Tidak ada pesanan yang bisa dikirim</p>";
        } else {
            echo "<p>Terdapat $i pesanan yang bisa dikirim</p>";
        }
    
    ?>
</body>

</html>