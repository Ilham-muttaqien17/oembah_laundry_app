<?php 
require 'functions.php';

if(isset($_POST['register'])){
    $register = registerLaundry($_POST);
    if($register['is_ok'] === false) {
        header('location: register.php?err=' . $register['msg']);
    } else {
        header('location: register.php?success=' . $register['msg']);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Registerasi Mitra</title>

        <!-- Font Family -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet" />

        <!-- JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>

        <link rel="stylesheet" href="./css/output.css" />
    </head>
    <body class="bg-gray-soft">
        <form class="regis-form" action="" method="POST">
            <img class="logo" src="../img/icons/oembah.svg" alt="" />
            <a class="flex items-center space-x-2 text-gray-200 text-xs" href="#">
                <img class="w-4" src="../img/icons/arrow_left_icon.svg" alt="Arrow Icon" />
                <span class="hover:underline">Kembali</span>
            </a>
            <h1 class="text-white font-semibold text-xl text-center mt-4 mb-8">Pendaftaran Mitra</h1>

            <?php 
                if(isset($_GET['err'])) {
                    echo "<div class='bg-red-200 text-sm text-red-800 py-2 px-2 w-full mt-4 mb-2 rounded'>" . $_GET['err'] . "</div>";
                }
                if(isset($_GET['success'])) {
                    echo "<div class='bg-green-200 text-sm text-green-800 py-2 px-2 w-full mt-4 mb-2 rounded'>" . $_GET['success'] . "</div>";
                }
            ?>

            <ul>
                <li>
                    <label class="label" for="nama">Nama lengkap</label>
                    <input id="nama" name="name" class="form-input" type="text" placeholder="Nama lengkap" required />
                </li>
                <li>
                    <label class="label" for="email">Email</label>
                    <input id="email" name="email" class="form-input" type="email" placeholder="Email" required />
                </li>
                <li>
                    <label class="label" for="password">Kata sandi</label>
                    <input id="password" name="password" class="form-input" type="password" placeholder="Password" required />
                </li>
                <li>
                    <label class="label" for="confirm_password">Ulangi kata sandi</label>
                    <input id="confirm_password" name="confirm" class="form-input" type="password" placeholder="Ulangi Password" required />
                </li>
                <li>
                    <label class="label" for="biaya">Biaya</label>
                    <input id="biaya" name="biaya" class="form-input" type="number" placeholder="0" required />
                </li>
                <li>
                    <label class="label" for="kontak">Nomor hp (Whatsapp)</label>
                    <input id="kontak" name="kontak" class="form-input" type="number" placeholder="08xxxx" required />
                </li>
            </ul>
            <div class="grid grid-cols-1 lg:grid-cols-1 gap-4 mt-2">
                <div class="">
                    <label class="label">Hari Kerja</label>
                    <div class="flex items-center w-full justify-between gap-x-4">
                        <select class="dropdown-input" name="hari_mulai" id="hari_mulai" required>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                        <span class="label">sampai</span>
                        <select class="dropdown-input" name="hari_akhir" id="hari_akhir" required>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-x-4">
                    <div class="">
                        <label class="label" for="jam_buka">Jam buka</label>
                        <input name="open_time" class="form-input" id="jam_buka" type="time" />
                    </div>
                    <div>
                        <label class="label" for="jam_tutup">Jam tutup</label>
                        <input name="close_time" class="form-input" id="jam_tutup" type="time" />
                    </div>
                </div>
                <div>
                    <label class="label" for="tipe_laundry">Tipe laundry</label>
                    <select class="dropdown-input" name="jenis" id="tipe_laundry">
                        <option value="Kiloan">Kiloan</option>
                        <option value="Sepatu">Sepatu</option>
                        <option value="Helm">Helm</option>
                        <option value="Hotel">Hotel</option>
                    </select>
                </div>
            </div>
            <div class="flex flex-col mt-5">
                <label class="label mb-2" for="alamat">Gunakan marker pada peta untuk memilih alamat</label>
                <input id="alamat" name="alamat" class="form-input" type="text" readonly required />
                <input type="text" name="latitude" id="latitude" readonly />
                <input type="text" name="longitude" id="longitude" readonly />
                <div id="map_canvas"></div>
            </div>
            <div class="mt-5 mb-10 space-x-4 flex items-center">
                <input type="checkbox" name="term" id="term" required/>
                <label class="text-sm text-gray-200" for="term">Saya menyetujui Syarat & Ketentuan serta Kebijakan Privasi layanan ini</label>
            </div>
            <div class="flex flex-col mt-10">
                <button class="btn-login mx-auto" name="register">Daftar</button>
                <div class="text-sm text-gray-200 mx-auto gap-x-2 gap-y-2 mt-4 flex items-center flex-col lg:flex-row">
                    <p class="">Sudah memiliki akun?</p>
                    <a class="font-semibold underline hover:text-violet-500" href="./login.php">Masuk</a>
                </div>
            </div>
        </form>

        <script>
            function initialize() {
                const successCallback = (position) => {
                    var lat = position.coords.latitude;
                    var long = position.coords.longitude;

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
