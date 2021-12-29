<?php 
require '../functions.php';
session_start();

if(checkCookie($_COOKIE) === true) {
    $_SESSION['user'] = $_COOKIE['user_email'];
}

if(!isset($_SESSION['user'])){
    header('location: login.php');
}

$user = getUserProfile($_SESSION['user']);

$sresult = '';

if(isset($_POST['search'])) {
    if(isset($_POST['keyword'])) {
        $sresult = searchLaundry($_POST['keyword']);
    }
}


?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Search Result</title>

        <!-- Font Family -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet" />

        <!-- JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
        <script src="../js/script.js"></script>

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

        <!-- Search Laundry -->
        <div id="search-menu" class="body-container">
            <h1 class="sub-title">Mau cari laundry?</h1>
            <form action="" method="POST">
                <input placeholder="Masukkan nama/lokasi" type="text" name="keyword" id="keyword" required />
                <img src="../img/icons/search_icon.svg" alt="Search Icon" />
                <button class="" type="submit" name="search">Cari</button>
                <div id="result" class=""></div>
            </form>
        </div>

        <!-- Tipe Laundry -->
        <div class="body-container">
            <h1 class="sub-title">Filter Tipe Laundry</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-x-8 gap-y-4 mt-5">
                <a id="btn-all" class="btn-laundry-type bg-dark-blue text-white hover:bg-dark-blue hover:text-white" href="#">Semua</a>
                <a id="btn-kiloan" class="btn-laundry-type bg-white text-dark-blue hover:bg-dark-blue hover:text-white" href="#">Kiloan</a>
                <a id="btn-sepatu" class="btn-laundry-type bg-white text-dark-blue hover:bg-dark-blue hover:text-white" href="#">Sepatu</a>
                <a id="btn-helm" class="btn-laundry-type bg-white text-dark-blue hover:bg-dark-blue hover:text-white" href="#">Helm</a>
                <a id="btn-hotel" class="btn-laundry-type bg-white text-dark-blue hover:bg-dark-blue hover:text-white" href="#">Hotel</a>
            </div>
        </div>

        <!-- Hasil Pencarian -->
        <div class="body-container">
            <div class="grid grid-cols-2">
                <h1 class="sub-title">Hasil Pencarian</h1>
            </div>

            <?php if(sizeof($sresult) < 1) {
                echo '<p>Tidak ada hasil yang sesuai dengan keyword "' . $_POST['keyword'] . '"</p>';
            } else {
                echo '<p>Ditemukan ' . sizeof($sresult) . ' hasil yang sesuai dengan keyword "' . $_POST['keyword'] . '"</p>';
            }
            ?>

            <!-- All Results -->
            <div id="all-result" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-y-6 mt-5">
                <?php for($i = 0; $i < sizeof($sresult); $i++) : ?>
                    <div class="card-laundry mx-auto" onclick="location.href='detail_laundry.php?id=<?= $sresult[$i]['id_laundry']; ?>'">
                        <img class="card-img" src="https://via.placeholder.com/140x100" alt="Foto Laundry" />
                        <div class="space-y-2 mt-2">
                            <p class="text-dark-blue bg-gray-soft w-20 text-center rounded-lg"><?= $sresult[$i]['tipe_laundry']; ?></p>
                            <p class="text-white font-semibold"><?= $sresult[$i]['nama_laundry']; ?></p>
                            
                            <p class="text-gray-300 text-sm truncate"><?= $sresult[$i]['alamat']; ?></p>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>

            <!-- Kiloan Results -->
            <div id="kiloan-result" class="hidden grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-y-6 mt-5">
                <?php foreach($sresult as $row) : ?>
                    <?php if($row['tipe_laundry'] === "Kiloan" ) : ?>
                    <div class="card-laundry mx-auto" onclick="location.href='detail_laundry.php?id=<?= $row['id_laundry']; ?>'">
                        <img class="card-img" src="https://via.placeholder.com/140x100" alt="Foto Laundry" />
                        <div class="space-y-2 mt-2">
                            <p class="text-dark-blue bg-gray-soft w-20 text-center rounded-lg"><?= $row['tipe_laundry']; ?></p>
                            <p class="text-white font-semibold"><?= $row['nama_laundry']; ?></p>
                            
                            <p class="text-gray-300 text-sm truncate"><?= $row['alamat']; ?></p>
                        </div>
                    </div>
                    <?php endif?>
                <?php endforeach; ?>
            </div>

            <!-- Sepatu Results -->
            <div id="sepatu-result" class="hidden grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-y-6 mt-5">
                <?php foreach($sresult as $row) : ?>
                    <?php if($row['tipe_laundry'] === "Sepatu" ) : ?>
                    <div class="card-laundry mx-auto" onclick="location.href='detail_laundry.php?id=<?= $row['id_laundry']; ?>'">
                        <img class="card-img" src="https://via.placeholder.com/140x100" alt="Foto Laundry" />
                        <div class="space-y-2 mt-2">
                            <p class="text-dark-blue bg-gray-soft w-20 text-center rounded-lg"><?= $row['tipe_laundry']; ?></p>
                            <p class="text-white font-semibold"><?= $row['nama_laundry']; ?></p>
                            
                            <p class="text-gray-300 text-sm truncate"><?= $row['alamat']; ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <!-- Helm Results -->
            <div id="helm-result" class="hidden grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-y-6 mt-5">
                <?php foreach($sresult as $row) : ?>
                    <?php if($row['tipe_laundry'] === "Helm" ) : ?>
                    <div class="card-laundry mx-auto" onclick="location.href='detail_laundry.php?id=<?= $row['id_laundry']; ?>'">
                        <img class="card-img" src="https://via.placeholder.com/140x100" alt="Foto Laundry" />
                        <div class="space-y-2 mt-2">
                            <p class="text-dark-blue bg-gray-soft w-20 text-center rounded-lg"><?= $row['tipe_laundry']; ?></p>
                            <p class="text-white font-semibold"><?= $row['nama_laundry']; ?></p>
                            
                            <p class="text-gray-300 text-sm truncate"><?= $row['alamat']; ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <!-- Hotel Results -->
            <div id="hotel-result" class="hidden grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-y-6 mt-5">
                <?php foreach($sresult as $row) : ?>
                    <?php if($row['tipe_laundry'] === "Hotel" ) : ?>
                    <div class="card-laundry mx-auto" onclick="location.href='detail_laundry.php?id=<?= $row['id_laundry']; ?>'">
                        <img class="card-img" src="https://via.placeholder.com/140x100" alt="Foto Laundry" />
                        <div class="space-y-2 mt-2">
                            <p class="text-dark-blue bg-gray-soft w-20 text-center rounded-lg"><?= $row['tipe_laundry']; ?></p>
                            <p class="text-white font-semibold"><?= $row['nama_laundry']; ?></p>
                            
                            <p class="text-gray-300 text-sm truncate"><?= $row['alamat']; ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
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
