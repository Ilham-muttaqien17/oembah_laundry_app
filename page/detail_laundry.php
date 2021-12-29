<?php
require '../functions.php';
session_start();

if(checkCookie($_COOKIE) === true) {
    $_SESSION['user'] = $_COOKIE['user_email'];
}

if(!isset($_SESSION['user'])){
    header('location: login.php');
}

if(isset($_POST['order'])) {
    $email = $_SESSION['user'];
    $id_laundry = $_GET['id'];
    $qty = $_POST['qty'];

    date_default_timezone_set('Asia/Jakarta');
    $tgl_order = date("Y-m-d h:i:sa");

    $order = addOrder($email, $id_laundry, $qty, $tgl_order);

    $transaksi = addTransaction($id_laundry, $qty, $tgl_order);


    if($order > 0) {
        echo "<script>alert('Pesanan berhasil dibuat, silahkan tunggu konfirmasi!');
        document.location.href = index.php</script>";
    } else {
        echo "<script>alert('Pesanan gagal dibuat, mohon ulangi lagi!');
        document.location.href = detail_laundry.php</script>";
    }

    
}

$user = getUserProfile($_SESSION['user']);


?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
        <?php if(isset($_GET['id'])) : ?>
        <?php $laundry = getDetailLaundry($_GET['id']); ?>
        <title><?= $laundry["nama_laundry"]; ?></title>
        <?php endif ?>

        <!-- Font Family -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet" />

        <!-- JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
        <script src="../js/script.js"></script>

        <!-- CSS -->
        <link rel="stylesheet" href="../css/output.css" />
    </head>
    <body class="bg-gray-soft">
        <!-- Navbar -->
        <nav id="navbar" class="nav-user">
            <div class="nav-content">
                <div class="nav-left-side">
                    <a href="./">
                        <img class="w-14 h-14" src="../img/icons/logo_oembah.svg" alt="logo_oembah" />
                    </a>
                    <div class="hidden lg:block">
                        <ul class="nav-links">
                            <li class="nav-link"><a href="#">Pesanan</a></li>
                            <li class="nav-link"><a href="#">Riwayat</a></li>
                            <li class="nav-link"><a href="#">Notifikasi</a></li>
                        </ul>
                    </div>
                </div>
                <a class="nav-right-side" href="./profile.php">
                    <span class="text-dark-blue text-lg font-semibold"><?= $user['nama_user'];?></span>
                    <img class="profile-img" src="../img/<?= !empty($user['image']) ? '../img/profile/'.$user['image'] : 'default_profile.png'?>" alt="Profile Image" />
                </a>
                <a id="toggle-menu" class="flex lg:hidden"><img class="w-8 h-8 border-8 border-gray-soft ring-2 ring-dark-blue rounded" src="../img/icons/menu_icon.svg" alt="Menu Icon" /></a>
            </div>
            <div id="item-menu-mobile" class="top-[5.5rem] absolute w-full bg-gray-soft hidden lg:hidden drop-shadow-lg">
                <hr class="border border-dark-blue w-11/12 mx-auto" />
                <ul class="relative mobile-links">
                    <li class="mobile-link"><a href="./profile.php">Profile</a></li>
                    <li class="mobile-link"><a href="#">Pesanan</a></li>
                    <li class="mobile-link"><a href="#">Riwayat</a></li>
                    <li class="mobile-link"><a href="#">Notifikasi</a></li>
                </ul>
            </div>
        </nav>

        <!-- Content -->
        <?php if(isset($_GET['id'])) : ?>
        <?php $laundry = getDetailLaundry($_GET['id']); ?>

        <div class="w-10/12 lg:w-6/12 mx-auto mb-24 mt-12 space-y-4 text-sm sm:text-base">
            <img class="w-full" src="<?= !empty($laundry["image"]) ? '' : '../img/dummy_laundry.png'?>" alt="" />
            <ul class="grid grid-cols-1 gap-y-6">
                <li class="text-dark-blue flex flex-col gap-y-2">
                    <div class="flex items-center gap-x-8">
                        <h3 class="font-bold"><?= $laundry["nama_laundry"]; ?></h3>
                        <span class="bg-white font-semibold px-4 py-1 rounded-lg shadow-md"><?= $laundry["tipe_laundry"] ?></span>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <img src="../img/icons/marker_icon.svg" alt="Marker Icon" />
                        <p><?= $laundry["alamat"] ?></p>
                    </div>
                </li>
                <li class="text-dark-blue flex flex-col gap-y-2">
                    <div class="flex items-center gap-x-2">
                        <img src="../img/icons/clock_icon.svg" alt="Clock Icon" />
                        <h3 class="font-bold">Jam Operasional</h3>
                    </div>
                    <div class="flex items-center gap-x-4">
                        <p><?= $laundry["hari_mulai"] . " - " . $laundry["hari_akhir"] ?></p>
                        <p><?= $laundry["jam_buka"]  . " - " . $laundry["jam_tutup"] ?></p>
                    </div>
                </li>
                <li class="text-dark-blue flex flex-col gap-y-2">
                    <div class="flex items-center gap-x-2">
                        <img src="../img/icons/dollar_icon.svg" alt="Dolar Icon" />
                        <h3 class="font-bold">Biaya Jasa</h3>
                    </div>
                    <div class="flex items-center gap-x-4">
                        <p><?= "Laundry " .  $laundry["tipe_laundry"] ?></p>
                        <p>
                            <?php 
                            switch($laundry["tipe_laundry"]) {
                                case "Kiloan":
                                    echo $laundry["biaya"] . "/kg";
                                    break;
                                case "Sepatu":
                                    echo $laundry["biaya"] . "/pasang";
                                    break;
                                case "Helm":
                                    echo $laundry["biaya"] . "/satuan";
                                    break;
                                case "Hotel":
                                    echo $laundry["biaya"] . "/kg";
                                    break;
                                default:
                                    break;
                            }
                            ?>
                        </p>
                        
                    </div>
                </li>
                <li class="flex items-center gap-x-4">
                    <a class="bg-white flex items-center gap-x-2 px-4 py-2 rounded-lg shadow-md" href="https://wa.me/<?= $laundry["kontak"] ?>">
                        <img src="../img/icons/whatsapp_icon.svg" alt="Whatsapp Icon" />
                        <span class="font-semibold text-dark-blue"> Chat Penjual</span>
                    </a>
                    <button id="btn-open-modal" class="text-white bg-dark-blue px-4 py-2 rounded-lg shadow-md font-semibold">Pesan Sekarang</button>
                </li>
            </ul>
        </div>

        <!-- Overlay -->
        <div id="overlay" class="fixed hidden inset-0 bg-dark-blue bg-opacity-50 z-10 justify-center items-center text-sm sm:text-base">
            <!-- Modal -->
            <div class="relative bg-white rounded-lg w-11/12 sm:w-7/12 md:w-6/12 lg:w-5/12 xl:w-4/12">
                <img id="btn-close-modal" class="w-6 absolute top-2 right-2 cursor-pointer" src="../img/icons/close_icon.svg" alt="Close Image" />
                <form class="p-10 flex flex-col gap-y-4" action="" method="POST">
                    <h4 class="text-center text-dark-blue font-bold text-lg">Form Pemesanan</h4>
                    <img class="w-full" src="<?= !empty($laundry["image"]) ? '' : '../img/dummy_laundry.png'?>" alt="Laundry Image" />
                    <div class="flex flex-col gap-y-4 text-dark-blue">
                        <h3 class="font-bold"><?= $laundry["nama_laundry"]; ?></h3>
                        <div class="flex items-center gap-x-2">
                            <img src="../img/icons/marker_icon.svg" alt="Marker Icon" />
                            <p class="text-sm"><?= $laundry["alamat"]; ?></p>
                        </div>
                        <hr />
                        <div class="flex items-center justify-between">
                            <h3 class="font-bold">Tipe Laundry</h3>
                            <p><?= $laundry["tipe_laundry"]; ?></p>
                        </div>
                        <div class="flex items-center justify-between">
                            <h3 class="font-bold">Biaya Jasa</h3>
                            <p><?= "Rp " . $laundry["biaya"]; ?></p>
                        </div>
                        <div class="flex items-center justify-between">
                            <label class="font-bold" for="qty">Kuantitas (kg/satuan/pasang)</label>
                            <input class="bg-gray-300 outline-none ring ring-dark-blue ring-opacity-50 rounded w-2/12 pl-2" type="number" name="qty" id="qty" required />
                        </div>
                        <hr />
                    </div>

                    <button class="py-2 w-8/12 sm:w-6/12 xl:w-5/12 mx-auto bg-dark-blue text-white rounded-lg mt-4" name="order">Pesan Sekarang</button>
                </form>
            </div>

            <!-- Succes Order -->
            <div id="order-success-modal" class="relative bg-white px-6 py-8 hidden flex-col gap-y-4 rounded-lg">
                <img id="btn-close-modal" class="w-6 absolute top-2 right-2 cursor-pointer" src="../img/close_icon.svg" alt="Close Image" />

                <img class="w-20 mx-auto p-1 rounded-full border-2 border-dark-blue" src="../img/check_icon.svg" alt="Check Icon" />

                <h3 class="text-dark-blue text-center">
                    Pesananmu sudah masuk, tunggu <br />
                    toko konfirmasi permintaanmu ya!
                </h3>
                <a class="bg-dark-blue text-white flex items-center gap-x-2 w-8/12 py-2 mx-auto rounded-lg justify-center" href="">
                    <img class="" src="../img/whatsapp_icon_white.svg" alt="Whatsapp Icon" />
                    <span class="font-semibold">Chat Penjual</span>
                </a>
            </div>
        </div>

        <?php endif ?>

        <!-- Footer -->
        <footer>
            <div class="footer-container">
                <div class="footer-links">
                    <div>
                        <img class="w-14 h-14" src="../img/icons/logo_oembah.svg" alt="logo_oembah" />
                        <p class="text-dark-blue mt-2">Tak lagi takut kehabisan baju di musim hujan!</p>
                    </div>
                    <div class="footer-items">
                        <div>
                            <h1 class="text-dark-blue font-semibold">OEMBAH LAUNDRY</h1>
                            <ul class="grid grid-cols-1 xl:grid-cols-2 gap-x-4 gap-y-2 mt-4">
                                <li><a class="footer-item" href="#">Tentang Kami</a></li>
                                <li><a class="footer-item" href="#">Mitra Oembah</a></li>
                                <li><a class="footer-item" href="#">Pusat Bantuan</a></li>
                                <li><a class="footer-item" href="#">Blog Oembah</a></li>
                                <li><a class="footer-item" href="#">Booking Laundry</a></li>
                            </ul>
                        </div>
                        <div>
                            <ul>
                                <h1 class="text-dark-blue font-semibold">KEBIJAKAN</h1>
                                <div class="grid grid-cols-1 gap-x-4 gap-y-2 mt-4">
                                    <a class="footer-item" href="#">Kebijakan Privasi</a>
                                    <a class="footer-item" href="#">Syarat dan Ketentuan Umum</a>
                                </div>
                            </ul>
                        </div>
                        <div>
                            <h1 class="text-dark-blue font-semibold">HUBUNGI KAMI</h1>
                            <div class="grid grid-col-1 gap-x-4 gap-y-2 mt-4 text-sm">
                                <a class="footer-contacts" href="#">
                                    <img class="w-5" src="../img/icons/mail_icon.svg" alt="Logo Email" />
                                    <span>cs@oembah.xyz</span>
                                </a>

                                <a class="footer-contacts" href="#">
                                    <img class="w-5" src="../img/icons/call_icon.svg" alt="Logo Call" />
                                    <span>021-345-678-90</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="border border-gray-300" />

                <div class="footer-copyright">
                    <div class="flex items-center space-x-2">
                        <img class="w-4" src="../img/icons/copyrigth_icon.svg" alt="" />
                        <p class="text-dark-blue text-sm">Oembah.xyz, All rights reserved</p>
                    </div>
                    <div class="flex items-center space-x-8">
                        <a href="#"><img class="w-7" src="../img/icons/fb_icon.svg" alt="Icon Facebook" /></a>
                        <a href="#"><img class="w-7" src="../img/icons/instagram_icon.svg" alt="Icon Instagram" /></a>
                        <a href="#"><img class="w-7" src="../img/icons/youtube_icon.svg" alt="Icon Youtube" /></a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
