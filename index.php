<?php 
require 'functions.php';

session_start();

if(!isset($_SESSION['user'])){
    header('location: login.php');
}

if(!isset($_COOKIE['user_email'])) {
    setcookie('user_email', '', time() - 3600);
    unset($_SESSION['user']);
    header('location: login.php');
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap 4.4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

    <script type="text/javascript" src="js/script.js"></script>
    
    <style>
        #allPositions, #userPosition {
            display: none;
        }
    </style>


</head>

<body>
    <h1>Welcome to Dashboard</h1>
    <div>
        <a class="btn btn-secondary" href="page/orders.php">Orders</a>
        <a class="btn btn-secondary" href="page/history_order.php">History</a>
        <a class="btn btn-secondary" href="#">Notification</a>
    </div>

    <a href="logout.php">Logout</a>

    <div class="d-flex flex-row">
        <?php $laundry = query("SELECT * FROM tb_laundry"); ?>
        <?php foreach( array_reverse($laundry) as $row ) : ?>
        <div class="card mx-4" style="width: 18rem;">
            <img class="card-img-top" src="https://via.placeholder.com/150" alt="">
            <div class="card-body">
                <p class="card-text">Nama Laundry: <?= $row['nama_laundry']; ?></p>
                <p class="card-text">Tipe Laundry: <?= $row['tipe_laundry']; ?></p>
                <p class="card-text">Alamat Laundry: <?= $row['alamat']; ?></p>
                <a class="btn btn-primary" href="detail_laundry.php?id=<?php echo $row['id_laundry']; ?>">Detail</a>

            </div>
        </div>

        <?php endforeach;?>
    </div>

    <?php 
    $allPositionLaundry = query("SELECT * FROM tb_laundry");
    $allPositionLaundry = json_encode($allPositionLaundry);

    $userEmail = $_COOKIE['user_email'];
    $userPosition = query("SELECT latitude,longitude,alamat FROM tb_user WHERE email = '$userEmail'");
    $userPosition = json_encode($userPosition);

    echo '<div id="userPosition">' . $userPosition . '</div>';
    echo '<div id="allPositions">' . $allPositionLaundry . '</div>';
    ?>

    <div id="map_canvas" style="width: 50%; height: 400px"></div>

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
                paragraf.textContent = data.alamat;
                linkDetail.href = 'http://localhost/FP-PWL/detail_laundry.php?id=' + parseInt(data.id_laundry);
                linkDetail.textContent = 'Cek Laundry'
                contentBoxLaundry.style.maxWidth = '150px';
                contentBoxLaundry.style.maxHeight = '100%';
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