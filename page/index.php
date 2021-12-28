<?php 
require '../functions.php';
session_start();

if(checkCookie($_COOKIE) === true) {
    $_SESSION['user'] = $_COOKIE['user_email'];
}

if(!isset($_SESSION['user'])){
    header('location: login.php');
}

if(isset($_GET['search'])) {
    $data = searchLaundry($_GET['keyword']);
    var_dump($data);
}

$laundry = query("SELECT * FROM tb_laundry"); 
$user = getUserProfile($_SESSION['user']);


?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Dashboard</title>

        <!-- Font Family -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet" />

        <!-- CSS -->
        <link rel="stylesheet" href="../css/output.css"/>

        <!-- Jquery -->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="../js/script.js"></script>

        <style>
            #allPositions,
            #userPosition {
                display: none;
            }
        </style>

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
        <div id="search-menu" class="body-container relative">
            <h1 class="sub-title">Mau cari laundry?</h1>
            <form action="" method="GET">
                <input placeholder="Masukkan nama/jenis/lokasi" type="text" name="keyword" id="keyword"/>
                <img src="../img/icons/search_icon.svg" alt="Search Icon" />
                <button type="submit" name="search" id="btn-search">Cari</button>
                <div id="result" class=""></div>
            </form>
            
        </div>

        <!-- Promo Laundry -->
        <!-- <div>
            <h1>Promo Laundry</h1>
            <div>
                
            </div>
        </div> -->

        <!-- Laundry Terdekat -->
        <?php 
            $data = getDistanceLaundry($_SESSION['user']);

            usort($data, function($a, $b) {
                return $a['distance'] > $b['distance'] ? 1 : -1;
            });
        ?>
        <div class="body-container">
            <h1 class="sub-title">Laundry Terdekat</h1>
            <div class="flex space-x-5 overflow-x-auto whitespace-nowrap mt-5">
                <?php for($i = 0; $i < sizeof($data); $i++) : ?>
                    <div class="card-laundry" onclick="location.href='detail_laundry.php?id=<?php echo $data[$i]['data']['id_laundry']; ?>'">
                        <img class="card-img" src="https://via.placeholder.com/140x100" alt="Foto Laundry" />
                        <div class="space-y-2 mt-2">
                            <p class="text-dark-blue bg-gray-soft w-20 text-center rounded-lg"><?= $data[$i]['data']['tipe_laundry']; ?></p>
                            <p class="text-white font-semibold"><?= $data[$i]['data']['nama_laundry']; ?></p>
                            <p class="text-gray-300 text-sm">Jarak laundry: <?= $data[$i]['distance'] . ' Km'; ?></p>
                            <p class="text-gray-300 text-sm truncate"><?= $data[$i]['data']['alamat']; ?></p>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Tipe Laundry -->
        <div class="body-container">
            <h1 class="sub-title">Tipe Laundry</h1>
            <div class="laundry-type-body">
                <a class="btn-laundry-type" href="#">Kiloan</a>
                <a class="btn-laundry-type" href="#">Sepatu</a>
                <a class="btn-laundry-type" href="#">Helm</a>
                <a class="btn-laundry-type" href="#">Hotel</a>
            </div>
        </div>

        <!-- Map -->
        <?php 
            $allPositionLaundry = query("SELECT * FROM tb_laundry");
            $allPositionLaundry = json_encode($allPositionLaundry);

            $userEmail = $_SESSION['user'];
            $userPosition = query("SELECT latitude,longitude,alamat FROM tb_user WHERE email = '$userEmail'");
            $userPosition = json_encode($userPosition);

            echo '<div id="userPosition">' . $userPosition . '</div>';
            echo '<div id="allPositions">' . $allPositionLaundry . '</div>';
        ?>                                                          
        <div class="w-10/12 mx-auto mt-14">
            <h1 class="sub-title">Cari laundry di sekitarmu</h1>
            <div class="w-full h-[350px] lg:h-[600px] mt-5" id="map_canvas"></div>
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
        <script>
            //user icon
            const myLocationIcon = "https://img.icons8.com/ios-filled/50/000000/men-age-group-4.png";

            //get user position
            var userPos = JSON.parse(document.getElementById('userPosition').innerHTML);
            var latitude = parseFloat(userPos[0].latitude);
            var longitude = parseFloat(userPos[0].longitude);
            var alamat = userPos[0].alamat;

            function initMap() {
                //initialize user position
                var map = new google.maps.Map(document.getElementById("map_canvas"), {
                    zoom: 14,
                    center: {lat: latitude, lng: longitude},
                });

                //Add message box user
                var infoBoxUser = new google.maps.InfoWindow;
                var contentUser = document.createElement('div');
                var bold = document.createElement('b');
                var paragraf = document.createElement('p');
                bold.textContent = 'Lokasi anda'
                paragraf.textContent = alamat;
                contentUser.style.maxWidth = '150px';
                contentUser.style.maxHeight = '100%';
                contentUser.appendChild(bold);
                contentUser.appendChild(paragraf);

                //Add marker on user position
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(latitude, longitude),
                    icon: myLocationIcon,
                    map: map
                })

                //Add click event on user marker
                marker.addListener('click', function(){
                    infoBoxUser.setContent(contentUser);
                    infoBoxUser.open(map, marker);
                })


                //load all Laundry Location
                var allPositionLaundry = JSON.parse(document.getElementById('allPositions').innerHTML);
                loadAllPositions(allPositionLaundry, map);
            }

            function loadAllPositions(data, map) {
                var infoBox = new google.maps.InfoWindow;
                Array.prototype.forEach.call(data, function(data){
                    //Add message box laundry
                    var contentBoxLaundry = document.createElement('div');
                    var bold = document.createElement('b');
                    var paragraf = document.createElement('p');
                    var linkDetail = document.createElement('a');
                    bold.textContent = data.nama_laundry;
                    bold.className = "text-dark-blue font-semibold";
                    paragraf.textContent = data.alamat;
                    linkDetail.href = 'http://localhost/FP-PWL/page/detail_laundry.php?id=' + parseInt(data.id_laundry);
                    linkDetail.textContent = 'Cek Laundry';
                    linkDetail.className = "text-dark-blue underline"
                    contentBoxLaundry.style.maxWidth = '150px';
                    contentBoxLaundry.style.maxHeight = '100%';
                    contentBoxLaundry.className = "flex flex-col gap-y-1";
                    contentBoxLaundry.appendChild(bold);
                    contentBoxLaundry.appendChild(paragraf);
                    contentBoxLaundry.appendChild(linkDetail);

                    //Add marker on laundry position
                    var vMarker = new google.maps.Marker({
                        position: new google.maps.LatLng(data.latitude, data.longitude),
                        map: map
                    });

                    //Add click event on marker laundry
                    vMarker.addListener('click', function(){
                        infoBox.setContent(contentBoxLaundry);
                        infoBox.open(map, vMarker);
                    })
                }) 
            }

        </script>

        <script async type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7So2OFuOg3mJdwU2h2lkoFz19E5GGag8&callback=initMap"></script>
    </body>
</html>
