<?php 
require 'functions.php';

if(isset($_POST['register'])){

    // check if the data was successfully added or not
    if(registerLaundry($_POST) > 0){
        echo "<script>
        alert('Berhasil mendaftarkan akun!'); 
        document.location.href = 'login.php'
        </script>";
    } else {
        echo "<script>
        alert('Gagal mendaftarkan akun!'); 
        document.location.href = 'login.php';
        </script>";
        echo mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regitrasi User</title>
    <!-- <script type="text/javascript" src="js/script.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
    

</head>

<body onload="initialize();">
    <h2>Registrasi Laundry</h2>
    <form action="" method="POST">
        <ul>
            <li>
                <label for="name">Nama: </label>
                <input type="text" name="name" id="name" required>
            </li>
            <li>
                <label for="email">Email: </label>
                <input type="email" name="email" id="email" required>
            </li>
            <li>
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" required>
            </li>
            <li>
                <label for="confirm">Konfirmasi Password: </label>
                <input type="password" name="confirm" id="confirm" required>
            </li>
            
            <li>
                <label for="biaya">Biaya: </label>
                <input type="number" min="0.00" name="biaya" id="biaya" required>
            </li>
            <li>
                <label for="kontak">Kontak: </label>
                <input type="text" name="kontak" id="kontak" required>
            </li>
            <li>
                <label for="jenis">Pilih jenis laundry</label>
                <select name="jenis" id="jenis" required>
                    <option value="Kiloan">Kiloan</option>
                    <option value="Sepatu">Sepatu</option>
                    <option value="Helm">Helm</option>
                    <option value="Hotel">Hotel</option>
                </select>
            </li>
            <li>
                <label for="open_time">Jam Buka: </label>
                <input type="time" name="open_time" id="open_time" required>
            </li>
            <li>
                <label for="close_time">Jam Buka: </label>
                <input type="time" name="close_time" id="close_time" required>
            </li>
            <li>
                <span>Gunakan Map untuk Menentukan Alamat</span><br>
                <label for="alamat">Alamat: </label>
                <input type="text" name="alamat" id="alamat" readonly required>
                <label for="latitude">Latitude</label>
                <input type="text" name="latitude" id="latitude" readonly>
                <label for="longitude">Longitude</label>
                <input type="text" name="longitude" id="longitude" readonly>
                <div id="map_canvas" style="width: auto; height: 400px"></div>

            </li>
            <li>
                <button name="register">Daftar Sekarang</button>
            </li>
        </ul>

    </form>

    <a href="login.php">Login</a>

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