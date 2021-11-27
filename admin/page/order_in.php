<?php 
require '../functions.php';

session_start();

if(!isset($_SESSION['admin'])){
    header('location: ../login.php');
}

if(isset($_COOKIE['admin_email'])) {
    $data = $_COOKIE['admin_email'];
} else {
    setcookie('admin_email', '', time() - 3600);
    unset($_SESSION['admin']);
    header('location: ../login.php');
}

$order = query("SELECT * FROM tb_order"); 

$message = '';

if(isset($_GET['id'])){

    if(confirmOrderIn($_GET['id']) > 0) {
        // echo "<script>alert('Pesanan berhasil dikonfirmasi!');</script>";
        $message = '<div class="alert alert-primary" role="alert">Pesanan berhasil dikonfirmasi</div>';
        
    } else {
        $message = '<div class="alert alert-primary" role="alert">Pesanan gagal dikonfirmasi</div>';
    }
    header('location: order_in.php');
}
// var_dump($message);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Order In</title>

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

    <h1>Halaman List Order In</h1>
    <a class="btn btn-secondary mb-5" href="../index.php">Home</a>

    <?php echo $message; ?>

    <?php $i = 0 ?>
    <?php foreach(array_reverse($order) as $row) : ?>
    <?php if(checkUser($data) == $row['id_laundry']) :?>
    <?php if($row['status'] == 'Waiting') : ?>
    <div class="card my-4 w-25">
        <p>Order ID: <?= $row['id_order'] ?></p>
        <?php $userName = getUserName($row['id_user'])?>
        <p>Nama Pelanggan: <?= $userName ?></p>
        <p>Kuantitas: <?= $row['qty'] ?></p>
        <p>Tipe Antar: <?= $row['tipe_antar'] ?></p>
        <a href="order_in.php?id=<?= $row['id_order']; ?>" onclick="return confirm('Konfirmasi pesanan?');"
            class="btn btn-primary">Konfirmasi Pesanan</a>
    </div>
    <?php $i++; ?>
    <?php endif ?>
    <?php endif ?>
    <?php endforeach ?>

    <?php
    global $i;
   
        if($i <= 0){
            echo "<p>Tidak ada order masuk</p>";
        } else {
            echo "<p>Terdapat $i order yang belum dikonfirmasi</p>";
        }
    
    ?>

</body>

</html>