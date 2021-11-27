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

if(isset($_GET['id'])){

    if(processOrderIn($_GET['id']) > 0) {
        // echo "<script>alert('Pesanan berhasil dikonfirmasi!');</script>";
        $message = '<div class="alert alert-primary" role="alert">Pesanan berhasil dikonfirmasi</div>';
        
    } else {
        $message = '<div class="alert alert-primary" role="alert">Pesanan gagal dikonfirmasi</div>';
    }
    header('location: on_process.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>On Process</title>
</head>

<body>
    <h1>Halaman List On Process</h1>
    <a class="btn btn-secondary mb-5" href="../index.php">Home</a>


    <?php $i = 0 ?>
    <?php foreach($order as $row) : ?>
    <?php if(checkUser($data) == $row['id_laundry']) :?>
    <?php if($row['status'] == 'Confirmed') : ?>
    <div class="card my-4 w-25">
        <p>Order ID: <?= $row['id_order'] ?></p>
        <?php $userName = getUserName($row['id_user'])?>
        <p>Nama Pelanggan: <?= $userName ?></p>
        <p>Kuantitas: <?= $row['qty'] ?></p>
        <p>Tipe Antar: <?= $row['tipe_antar'] ?></p>
        <a href="on_process.php?id=<?= $row['id_order']; ?>" onclick="return confirm('Proses pesanan?');"
            class="btn btn-primary">Proses Pesanan</a>
    </div>
    <?php $i++; ?>
    <?php endif ?>
    <?php endif ?>
    <?php endforeach ?>

    <?php
    global $i;
   
        if($i <= 0){
            echo "<p>Tidak ada pesanan yang bisa diproses</p>";
        } else {
            echo "<p>Terdapat $i pesanan yang bisa diproses</p>";
        }
    
    ?>


</body>

</html>