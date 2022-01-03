<?php
require '../functions.php';

session_start();

if(checkCookie($_COOKIE) === true) {
    $_SESSION['admin'] = $_COOKIE['admin_email'];
}

if(!isset($_SESSION['admin'])){
    header('location: ../login.php');
}

$laundry_id = checkUser($_SESSION['admin']);

$order = query("SELECT * FROM tb_order INNER JOIN tb_user ON tb_user.id_user = tb_order.id_user WHERE tb_order.id_laundry = '$laundry_id'"); 

$confirmedOrder = countOrder($_SESSION['admin'], "Confirmed");

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
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Process Order</title>

        <!-- Font Family -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet" />

        <!-- JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
        <script src="../js/script.js"></script>

        <link rel="stylesheet" href="../css/output.css" />
    </head>
    <body>
        <div class="flex flex-row">
            <!-- Sidebar -->

            <nav id="navbar" class="bg-dark-blue px-4 py-8 h-screen w-[60px] fixed left-0 top-0 z-10 transition-all duration-150 ease-in-out">
                <div class="flex items-center gap-x-4 text-white cursor-pointer">
                    <img id="open-menu" class="w-7 flex" src="../img/icons/menu_icon.svg" alt="Menu Icon" />
                    <span class="nav-link hidden font-bold">OEMBAH</span>
                </div>
                <ul class="flex flex-col gap-y-8 mt-10">
                    <li title="Dashboard">
                        <a class="flex items-center gap-x-4 text-white" href="../">
                            <img class="w-7" src="../img/icons/home_icon.svg" alt="Dashboard Icon" />
                            <span class="nav-link hidden">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-x-4 text-white" href="#">
                            <img class="w-7" src="../img/icons/statistic_icon.svg" alt="Statistic Icon" />
                            <span class="nav-link hidden">Statistik</span>
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-x-4 text-white" href="profile.php">
                            <img class="w-7" src="../img/icons/profile_icon.svg" alt="Profile Icon" />
                            <span class="nav-link hidden">Profile</span>
                        </a>
                    </li>
                </ul>
                <div>
                    <a class="absolute bottom-4 flex items-center gap-x-4 text-white" href="../logout.php">
                        <img class="w-7" src="../img/icons/logout_icon.svg" alt="Logout Icon" />
                        <span class="nav-link hidden">Keluar</span>
                    </a>
                </div>
            </nav>

            <!-- Overlay -->
            <div id="overlay" class="bg-dark-blue bg-opacity-50 absolute inset-0 hidden"></div>

            <!-- Content -->
            <main class="w-full bg-gray-soft ml-[3.7rem] h-screen px-2 overflow-y-scroll">
                <div class="flex my-8">
                    <h1 class="mx-auto text-dark-blue font-bold text-xl lg:text-2xl">PROCESS ORDER</h1>
                </div>

                <hr class="w-full" />

                <div class="flex flex-col gap-y-4 py-4 w-11/12 mx-auto text-sm lg:text-base">
                    <div class="flex items-center gap-x-2">
                        <div class="bg-red-600 w-4 h-4 rounded-full"></div>
                        <p class="text-dark-blue font-semibold">Terdapat <?= sizeof($confirmedOrder); ?> order yang bisa di proses</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-4 gap-y-4">

                    <?php foreach(array_reverse($order) as $row) : ?>
                    <?php if($laundry_id == $row['id_laundry']) :?>
                    <?php if($row['status'] == 'Confirmed') : ?>
                        <div class="bg-dark-blue p-4 rounded-xl flex flex-col gap-y-4 text-xs md:text-sm lg:text-base">
                            <div class="bg-white p-2 text-dark-blue font-semibold rounded-lg flex-1">
                                <div class="flex flex-col">
                                    <div class="grid grid-cols-3">
                                        <p>Order ID</p>
                                        <p class="col-span-2">: <?= $row['id_order'] ?></p>
                                    </div>
                                    <div class="grid grid-cols-3">
                                        <p>Nama</p>
                                        <p class="col-span-2">: <?= $row['nama_user'] ?></p>
                                    </div>
                                    <div class="grid grid-cols-3">
                                        <p>Alamat</p>
                                        <p class="col-span-2">: <?= $row['alamat'] ?></p>
                                    </div>
                                    <div class="grid grid-cols-3">
                                        <p>Kuantitas</p>
                                        <p>: <?= $row['qty'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <a class="flex items-center bg-green-600 text-white font-semibold justify-center py-2 rounded-lg gap-x-2" href="on_process.php?id=<?= $row['id_order']; ?>" onclick="return confirm('Proses pesanan?');">
                                    <span>PROSES PESANAN</span>
                            </a>
                            <a class="flex items-center bg-white text-dark-blue font-semibold justify-center py-2 rounded-lg gap-x-2" href="https://wa.me/<?= $row['kontak']; ?>" target="_blank">
                                <img src="../img/icons/whatsapp_icon.svg" alt="Whatsapp Icon" />
                                <span>Chat User</span>
                            </a>
                        </div>
                    <?php endif ?>
                    <?php endif ?>
                    <?php endforeach ?>

                    </div>
                </div>
            </main>
        </div>
    </body>
</html>