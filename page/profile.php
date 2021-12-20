<?php 

require '../functions.php';

session_start();

if(!isset($_SESSION['user'])){
    header('location: ../login.php');
}

if(!isset($_COOKIE['user_email'])) {
    setcookie('user_email', '', time() - 3600);
    unset($_SESSION['user']);
    header('location: ../login.php');
}

$user = getUserProfile($_GET['uid']);

$message = null;

if(isset($_POST['edit'])) {
    if(editUserProfile($_POST, $_GET['uid'], $_FILES['img_profile']) > 0) {
        $message = 'true';
        header('location: profile.php?uid='.$_GET["uid"].'&status_edit='.$message);
    } else {
        $message = 'false';
        header('location: profile.php?uid='.$_GET["uid"].'&status_edit='.$message);
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
        <title>Profile User</title>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>

    </head>
    <body>
        <h1>Halo <?php echo $user['nama_user'] ?></h1>
        
        <div>
            <h2>Profile User</h2>
            <a href="./index.php">Home</a><br>
            <p><?= !empty($message) ? $_GET['status_edit'] : $message?></p><br>
            <?php
                if(isset($_GET['status_edit'])){
                    if($_GET['status_edit'] == 'true') {
                        $message = "<b>Berhasil mengubah data</b><br>";
                    } else {
                        $message = "<b>Tidak ada data yang berubah</b><br>";
                    }
                }
            ?>
            <?= $message?>
            <img style="width: 50px; height: 50px;" src="<?= !empty($user['image']) ? '../img/profile/'.$user['image'] : '../img/default_profile.png'?>" alt="Profile Image">
            <form action="" method="POST" enctype="multipart/form-data">
                <ul>
                    <li>
                        <label for="name">Nama: </label>
                        <input type="text" name="name" value="<?= $user['nama_user']?>" id="name">
                    </li>
                    <li>
                        <label for="email">Email: </label>
                        <input type="email" name="email" value="<?= $user['email']?>" id="email" disabled>
                    </li>
                    <li>
                        <label for="img_profile">Upload Foto Profile</label>
                        <input type="file" name="img_profile" id="img_profile">

                        <!-- Hidden input -->
                        <input type="hidden" name="old_profile" value="<?= $user['image']?>">
                    </li>
                    <li>
                        <label for="kontak">Kontak: </label>
                        <input type="text" name="kontak" value="<?= $user['kontak']?>" id="kontak">
                    </li>
                    <li>
                        <label for="alamat">Alamat: </label>
                        <input type="text" name="alamat" value="<?= $user['alamat']?>" id="alamat" readonly>
                        <label for="latitude">Latitude</label>
                        <input type="text" name="latitude" value="<?= $user['latitude']?>" id="latitude" readonly>
                        <label for="longitude">Longitude</label>
                        <input type="text" name="longitude" value="<?= $user['longitude']?>" id="longitude" readonly>
                        <div id="map_canvas" style="width: 50%; height: 400px"></div>

                    </li>
                    <li>
                        <button name="edit">Edit Profile</button>
                    </li>
                </ul>
            </form>
        </div>


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