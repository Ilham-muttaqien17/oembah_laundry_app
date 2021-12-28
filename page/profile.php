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

$message = null;
$edit = null;

if(isset($_POST['edit'])) {
    $edit = editUserProfile($_POST, $user['id_user'], $_FILES['img_profile']);
    $edit_status = $edit['is_ok'] ? "success" : "failed";
    header('location: profile.php?message=' . $edit['msg'] . '&edit='. $edit_status);
}

if(isset($_GET['delete_id'])) {
    if(deleteUser($_GET['delete_id']) > 0) {
        echo "
        <script>
            alert('Berhasil Mengahapus Akun');
            document.location.href = 'logout.php';
        </script>";
    } else {
        echo "
        <script>
            alert('Gagal Mengahapus Akun');
            document.location.href = 'profile.php';
        </script>";
    }
}



?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Profile</title>

        <!-- Font Family -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet" />

        <!-- JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
        <script src="../js/script.js"></script>

        <!-- CSS -->
        <link rel="stylesheet" href="../css/output.css?v=1" />
        <style>
            input[type = file]::-webkit-file-upload-button {
                visibility: hidden;
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
        <?php 
            if(isset($_GET['edit'])) {
                if($_GET['edit'] === "success") {
                    echo "<div class='bg-green-200 text-green-800 mx-auto py-2 px-2 w-11/12 sm:w-10/12 md:w-8/12 lg:w-9/12 xl:w-8/12 mt-8'>". $_GET['message'] . "</div>";
                } else {
                    echo "<div class='bg-red-200 text-red-800 mx-auto py-2 px-2 w-11/12 sm:w-10/12 md:w-8/12 lg:w-9/12 xl:w-8/12 mt-8'>" . $_GET['message'] . "</div>";
                }
            }
        ?>

        

        <main class="relative bg-white rounded-lg shadow-md w-11/12 sm:w-10/12 md:w-8/12 lg:w-9/12 xl:w-8/12 mx-auto 2xl:h-[800px] mt-10 px-6 lg:px-12 py-10">
            <form class="flex flex-col gap-y-6" action="" method="POST" enctype="multipart/form-data">
                <!-- Vertical Line -->
                <div class="absolute hidden lg:block top-0 lg:left-[200px] xl:left-[250px] border-r border-dark-blue border-opacity-50 lg:h-[830px] 2xl:h-[800px]"></div>

                <div class="items-center gap-x-36 grid grid-cols-1 lg:grid-cols-4">
                    <h3 class="text-dark-blue font-bold">Foto Profil</h3>
                    <div class="flex items-center lg:col-span-3 gap-x-4">
                        <img class="w-16 h-16 rounded-full" src="<?= !empty($user['image']) ? '../img/profile/'.$user['image'] : '../img/default_profile.png'?>" alt="Profile Image" />
                        <div class="">
                            <label class="text-dark-blue cursor-pointer" for="img_profile">Ubah foto profil</label>
                            <input class="" type="file" name="img_profile" id="img_profile" />

                            <!-- Hidden input -->
                            <input type="hidden" name="old_profile" value="<?= $user['image']?>">
                        </div>
                    </div>
                </div>
                <div class="items-center gap-x-36 grid grid-cols-1 lg:grid-cols-4">
                    <label class="text-dark-blue font-bold" for="name">Nama</label>
                    <input class="lg:col-span-3 text-dark-blue outline-none rounded pl-2 bg-white border h-8 border-dark-blue" type="text" name="name" value="<?= $user['nama_user']?>" id="name" />
                </div>
                <div class="items-center gap-x-36 grid grid-cols-1 lg:grid-cols-4">
                    <label class="text-dark-blue font-bold" for="kontak">Nomor Telepon</label>
                    <input class="lg:col-span-3 text-dark-blue outline-none rounded pl-2 bg-white border h-8 border-dark-blue" type="text" name="kontak" value="<?= $user['kontak']?>" id="kontak" />
                </div>
                <div class="items-center gap-x-36 grid grid-cols-1 lg:grid-cols-4">
                    <label class="text-dark-blue font-bold" for="email">Email</label>
                    <input class="lg:col-span-3 text-dark-blue outline-none rounded pl-2 bg-white border h-8 border-dark-blue" type="text" name="email" value="<?= $user['email']?>" id="email" disabled/>
                </div>
                <div class="items-center gap-x-36 grid grid-cols-1 lg:grid-cols-4">
                    <label class="text-dark-blue font-bold" for="password">Kata Sandi</label>
                    <input class="lg:col-span-3 text-dark-blue outline-none rounded pl-2 bg-white border h-8 border-dark-blue" type="password" placeholder="********" name="password" id="password" />
                </div>
                <div class="gap-x-36 grid grid-cols-1 lg:grid-cols-4">
                    <label class="text-dark-blue font-bold" for="alamat">Alamat</label>

                    <div class="lg:col-span-3">
                        <input class="w-full outline-none rounded pl-2 bg-white border h-8 border-dark-blue" type="text" name="alamat" value="<?= $user['alamat']?>" id="alamat" readonly />
                        <input type="text" name="latitude" value="<?= $user['latitude']?>" id="latitude" readonly hidden />
                        <input type="text" name="longitude" value="<?= $user['longitude']?>" id="longitude" readonly hidden />

                        <div class=" w-full" id="map_canvas" style="height: 250px"></div>
                    </div>
                </div>
                <div class="grid gap-y-10 grid-cols-1 lg:grid-cols-4 mt-4">
                    <div class="flex flex-col order-last lg:-order-last gap-y-1 mx-auto lg:-mx-0">
                        <a class="text-red-600 font-bold hover:bg-gray-200 w-28 text-center rounded-lg py-1" href="profile.php?delete_id=<?=$user['id_user'];?>">Hapus Akun</a>
                        <a class="text-white bg-dark-blue w-24 text-center rounded-lg py-1" href="logout.php">Keluar</a>
                    </div>
                    <button name="edit" class="lg:col-span-3 order-first lg:-order-first mx-auto lg:-mx-0 lg:ml-auto bg-dark-blue text-white h-8 px-4 rounded-lg">Simpan Perubahan</button>
                </div>
            </form>
        </main>

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
            function initialize() {
                const successCallback = (position) => {


                    var lat = document.getElementById('latitude').value;
                    var long = document.getElementById('longitude').value;

                    console.log(long);

                    // Creating map object
                    var map = new google.maps.Map(document.getElementById("map_canvas"), {
                        zoom: 12,
                        center: new google.maps.LatLng(lat, long),
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                    });

                    // creates a draggable marker to the given coords
                    var vMarker = new google.maps.Marker({
                        position: new google.maps.LatLng(lat, long),
                        draggable: true,
                    });

                    // adds a listener to the marker
                    // gets the coords when drag event ends
                    // then updates the input with the new coords
                    google.maps.event.addListener(vMarker, "dragend", function (evt) {
                        $("#latitude").val(evt.latLng.lat().toFixed(6));
                        $("#longitude").val(evt.latLng.lng().toFixed(6));

                        let myLat = evt.latLng.lat().toFixed(6);
                        let myLong = evt.latLng.lng().toFixed(6);

                        // const geoApiUrl = `https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${myLat}&longitude=${myLong}&localityLanguage=id`;

                        const geocodeApiReverse = `https://nominatim.openstreetmap.org/reverse.php?lat=${myLat}&lon=${myLong}&format=jsonv2`;

                        fetch(geocodeApiReverse)
                            .then((res) => res.json())
                            .then((data) => {
                                // console.log(data);
                                // var lengtAdministrative = Object.keys(data.localityInfo.administrative);
                                // $("#alamat").val(data.localityInfo.administrative[lengtAdministrative.length - 1].name + ", " + data.localityInfo.administrative[lengtAdministrative.length - 2].name);
                                $("#alamat").val(data.display_name);
                            });

                        map.panTo(evt.latLng);
                    });

                    // centers the map on markers coords
                    map.setCenter(vMarker.position);

                    // adds the marker on the map
                    vMarker.setMap(map);
                };

                const errorCallback = (error) => {
                    console.log(error);
                };

                navigator.geolocation.getCurrentPosition(successCallback, errorCallback, {
                    enableHighAccuracy: true,
                    timeout: 1000,
                });
            }

        </script>

        <script async type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7So2OFuOg3mJdwU2h2lkoFz19E5GGag8&callback=initialize" defer></script>
    </body>
</html>
