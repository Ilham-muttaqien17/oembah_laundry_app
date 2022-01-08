<?php 
require '../functions.php';
session_start();

if(checkCookie($_COOKIE) === true) {
    $_SESSION['user'] = $_COOKIE['user_email'];
}

if(!isset($_SESSION['user'])){
    header('location: login.php');
}

$data = $_SESSION['user'];

if(isset($_GET['cancel'])) {
    $cancel_id = $_GET['cancel'];
    if(deleteRequest($cancel_id) > 0) {
        echo "Pesanan Berhasil dibatalkan";
    } else {
        echo "Pesanan Gagal dibatalkan";
    }
    header('location: orders.php');
}

if(isset($_GET['confirm'])) {
    $confirm_id = $_GET['confirm'];
    if(confirmOrderSent($confirm_id) > 0) {
        echo "Pesanan Berhasil dibatalkan";
    } else {
        echo "Pesanan Gagal dibatalkan";
    }
    header('location: orders.php');
}

$user = getUserProfile($_SESSION['user']);
$order = query("SELECT * FROM tb_order 
                INNER JOIN tb_transaksi ON tb_order.id_order = tb_transaksi.id_order
                INNER JOIN tb_laundry ON tb_order.id_laundry = tb_laundry.id_laundry");

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Detail Laundry</title>

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
                            <li class="nav-link"><a href="./orders.php">Pesanan</a></li>
                            <li class="nav-link"><a href="./history_order.php">Riwayat</a></li>
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
        <div class="w-10/12 md:w-8/12 mx-auto mt-10 mb-20">
            <h1 class="text-dark-blue font-bold text-xl mb-10">Daftar pesanan</h1>
            <div class="flex flex-col w-full gap-y-4">
                <?php                
                    if(sizeof($order) < 1) {
                        echo "<div class='h-[220px] text-dark-blue text-sm'>Tidak ada pesanan yang dibuat</div>";
                    } else { 
                        foreach( array_reverse($order) as $row ) { 
                            if(checkUser($data) == $row['id_user']) {
                                if($row['status'] !== 'Delivered') {
                                    switch($row['tipe_laundry']) {
                                        case "Kiloan":
                                            $satuan = "kg";
                                            break;
                                        case "Sepatu":
                                            $satuan = "pasang";
                                            break;
                                        case "Helm":
                                            $satuan = "buah";
                                            break;
                                        case "Hotel":
                                            $satuan = "kg";
                                        default:
                                            break;
                                    }
                ?>

                    <div class="border p-4 rounded-xl shadow">
                        <div class="flex flex-col gap-x-4 gap-y-2 sm:flex-row sm:items-center">
                            <div class="flex items-center gap-x-4">
                                <p class="text-dark-blue font-bold text-sm">Pesanan</p>
                                <p class="text-dark-blue text-sm"><?= date("d M Y",strtotime($row['tgl_order']))?></p>
                            </div>

                            <p class="text-orange-400 font-semibold bg-yellow-200 rounded text-xs w-[150px] text-center"><?= $row['status'] ?></p>
                        </div>
                        <div class="flex flex-col gap-y-2 sm:flex-row lg:items-center mt-4">
                            <div class="flex-1 flex flex-col gap-y-2">
                                <h3 class="text-dark-blue font-bold"><?= $row['nama_laundry']?></h3>
                                <div class="flex items-center gap-x-4">
                                    <img src="../img/default_laundry.png" alt="Laundry Foto" />
                                    <div class="text-dark-blue">
                                        <p class="font-semibold"><?= "Laundry " . $row['tipe_laundry']. " - ". $row['qty'] . " " . $satuan ?></p>
                                        <p class="text-xs"><?= "1 " . $satuan . " x " . "Rp ". $row['biaya']?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="border-l-2 p-4 flex flex-col border-dark-blue border-opacity-20 text-dark-blue">
                                <p class="text-sm">Total Biaya</p>
                                <p class="font-bold"><?= $row['total_biaya'] ?></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-x-4 mt-6 justify-end">
                        <?php if($row['status'] == "Waiting") { ?>
                            <a class="px-4 py-1 border border-gray-400 rounded font-bold text-dark-blue" href="orders.php?cancel=<?=$row['id_order'] ?>"
                            onclick="return confirm('Hapus permintaan pesanan?');">Hapus permintaan</a>
                        <?php } ?>

                        <?php if($row['status'] == "Confirmed" || $row['status'] == "On Process") {?>
                            <a class="px-4 py-1 border border-gray-400 rounded font-bold text-dark-blue cursor-not-allowed text-opacity-40">Hapus permintaan</a>
                        <?php }?>

                        <?php if($row['status'] == "On Delivery") : ?>
                            <a class="px-4 py-1 border border-gray-400 rounded font-semibold bg-dark-blue text-white" href="orders.php?confirm=<?=$row['id_order'] ?>"
                            onclick="return confirm('Konfirmasi pesanan datang?');">Selesaikan Pesanan</a>
                        <?php endif ?>
                            <!-- <a class="px-4 py-1 border border-gray-400 rounded font-bold text-dark-blue" href="#">Hapus permintaan</a> -->
                            <a class="px-4 py-1 border border-gray-400 rounded" href="https://wa.me/<?= $row["kontak"]?>"><img src="../img/icons/whatsapp_icon.svg" alt="Whatsapp Icon" /></a>
                        </div>
                    </div>

                <?php 
                            }
                        }
                    }
                }
                ?>
            </div>
        </div>

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
