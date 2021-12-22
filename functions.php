<?php 

$conn = mysqli_connect("localhost", "root", "", "db_oembah");

function validateData($data) {
    global $conn;
    $data = mysqli_real_escape_string($conn,$data);
    
    return $data;
}

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function validateNumber($number) {
    // kadang ada penulisan no hp 0811 239 345
    $number = str_replace(" ","",$number);
    // kadang ada penulisan no hp (0274) 778787
    $number = str_replace("(","",$number);
    // kadang ada penulisan no hp (0274) 778787
    $number = str_replace(")","",$number);
    // kadang ada penulisan no hp 0811.239.345
    $number = str_replace(".","",$number);

    // cek apakah no hp mengandung karakter + dan 0-9
    if(!preg_match('/[^+0-9]/',trim($number))){
        // cek apakah no hp karakter 1-3 adalah 62
        if(substr(trim($number), 0, 2)=='62'){
            $numberValidated = trim($number);
        }
        // cek apakah no hp karakter 1 adalah 0
        elseif(substr(trim($number), 0, 1)=='0'){
            $numberValidated = '62'.substr(trim($number), 1);
        }
    }
    return $numberValidated;
}

function registerUser($data) {
    global $conn;
    $name = validateData($data['name']);
    $email = validateData($data['email']);
    $password = validateData($data['password']);
    $confirm = validateData($data['confirm']);
    $contact = validateNumber(validateData($data['kontak']));
    $address = validateData($data['alamat']);
    $latitude = $data['latitude'];
    $longitude = $data['longitude'];

    //check if email is already use or not
    $result = mysqli_query($conn, "SELECT email FROM tb_user WHERE email = '$email'");
    if(mysqli_fetch_assoc($result)){
        echo "<script>alert('Email sudah terdaftar')</script>";
        return false;
    }

    //check confirmation password
    if($password !== $confirm){
        echo "<script>alert('Password tidak sesuai')</script>";
        return false;
    }

    //encrypt password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //insert data to database
    $query = "INSERT INTO tb_user VALUES('', '$name', '$email', '$password', '$address', '$latitude', '$longitude', '$contact', '')";
    mysqli_query($conn, $query);
    

    return mysqli_affected_rows($conn);
}

function loginUser($data){
    global $conn;
    $email = validateData($data['email']);
    $password = validateData($data['password']);

    $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE email = '$email'");

    if(mysqli_num_rows($result) === 1) {
        //get all data from result
        $row = mysqli_fetch_assoc($result);

        //check password 
        if(password_verify($password, $row['password'])) {
            if(isset($data['rememberme'])){
                setcookie("user_email", $email, time() + (10 * 365 * 24 * 60 * 60));
            }
            $_SESSION['user'] = true;
            header('location: index.php');
            exit;
        } 
    }

    return false;
}

function checkCookie($cookie){
    global $conn;
    if(isset($cookie['user_email'])){
        $email = $cookie['user_email'];
        $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE email = '$email'");
        $row = mysqli_fetch_assoc($result);
        if($cookie['user_email'] == $row['email']){
            return true;
        }
    }

    return false;
    
}

function getDetailLaundry($data){
    global $conn;

    //convert string to int
    $id_laundry = (int) $data;
    $result = mysqli_query($conn, "SELECT * FROM tb_laundry WHERE id_laundry = '$id_laundry'");

    $row = mysqli_fetch_assoc($result);

    // var_dump($row);
    return $row;
}

function addOrder($email, $idLaundry, $jumlah, $tipe_antar, $tgl_order){
    global $conn;
    

    $query1 = mysqli_query($conn, "SELECT * FROM tb_user WHERE email = '$email'");
    $row1 = mysqli_fetch_assoc($query1);
    $userId = $row1['id_user'];

    $id_laundry = (int) $idLaundry;
    $id_user = (int) $userId;
    $qty = $jumlah;
    $status = 1;
    $type_delivery = $tipe_antar;
    $order_time = $tgl_order;

    mysqli_query($conn, "INSERT INTO tb_order VALUES('', '$qty', '$status', '$type_delivery', '$order_time', '$id_user', '$id_laundry')");

    
    return mysqli_affected_rows($conn);
}

function deleteRequest($data) {
    global $conn;
    $oid = (int) $data;

    mysqli_query($conn, "DELETE FROM tb_order WHERE id_order = $oid");

    return mysqli_affected_rows($conn);
}

function confirmOrderSent($data) {
    global $conn;
    $oid = $data;
    var_dump($oid);

    mysqli_query($conn, "UPDATE tb_order SET status = 5 WHERE id_order = '$oid'");
    mysqli_query($conn, "UPDATE tb_transaksi SET status_transaksi = 4 WHERE id_order = '$oid'");

    return mysqli_affected_rows($conn);
}

function checkUser($data) {
    global $conn;

    $query = mysqli_query($conn, "SELECT * FROM tb_user WHERE email = '$data' ");
    $row = mysqli_fetch_assoc($query);

    $lid = (int) $row['id_user'];

    return $lid;
}

function getLaundryName($data){
    global $conn;
    $data = (int) $data;

    $result = mysqli_query($conn, "SELECT * FROM tb_laundry WHERE id_laundry = '$data'");
    $row = mysqli_fetch_assoc($result);

    $lid = $row['nama_laundry'];

    return $lid;
}

function addTransaction($id_laundry, $qty, $tgl_order){
    global $conn;
    $query1 = mysqli_query($conn, "SELECT * FROM tb_order WHERE tgl_order = '$tgl_order'");
    $row1 = mysqli_fetch_assoc($query1);
    $oid = (int) $row1['id_order'];

    $query2 = mysqli_query($conn, "SELECT * FROM tb_laundry WHERE id_laundry = '$id_laundry'");
    $row2 = mysqli_fetch_assoc($query2);
    $price = $row2['biaya'];

    $status = 2;

    $total_cost = (int) $qty * (int) $price;

    date_default_timezone_set('Asia/Jakarta');
    $transac_date = date("Y-m-d h:i:sa");
    

    mysqli_query($conn, "INSERT INTO tb_transaksi VALUES ('', '$total_cost', '$transac_date', '$status', '$oid')");

    return mysqli_affected_rows($conn);
}

function getContactLaundry($data){
    global $conn;
    $data = (int) $data;

    $result = mysqli_query($conn, "SELECT * FROM tb_laundry WHERE id_laundry = '$data'");
    $row = mysqli_fetch_assoc($result);

    $lid = $row['kontak'];

    return $lid;
}

function calculateDistance($lat1, $long1, $lat2, $long2){
    $theta = $long1 - $long2;
    $miles = (sin(deg2rad($lat1))) * sin(deg2rad($lat2)) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $result = $miles * 60 * 1.1515 * 1.609344;
    $distance = round($result, 1);
    return $distance;
}

function getDistanceLaundry($email) {
    global $conn;

    $query = mysqli_query($conn, "SELECT * FROM tb_user WHERE email = '$email'");
    $result = mysqli_fetch_assoc($query);
    $userLat = (float)$result['latitude'];
    $userLong = (float)$result['longitude'];

    $query2 = mysqli_query($conn, "SELECT * FROM tb_laundry");
    $rows = [];
    while($row = mysqli_fetch_assoc($query2)) {
        $rows[] = $row;
    }

    $data = array();
    for($i = 0; $i < sizeof($rows); $i++){
        $distance = calculateDistance($userLat, $userLong, (float) $rows[$i]['latitude'], (float) $rows[$i]['longitude']);
        // $data[$i] = array('distance' => $distance, 'data' => $rows[$i]);
        array_push($data, array('distance' => $distance, 'data' => $rows[$i]));
    }

    return $data;
}

function searchLaundry($keyword) {

    $keyword = validateData($keyword);
    if(strlen($keyword) > 0) {
        $query = "SELECT * FROM tb_laundry WHERE 
                nama_laundry LIKE '%$keyword%' OR
                email LIKE '%$keyword%' OR
                alamat LIKE '%$keyword%' OR
                tipe_laundry LIKE '%$keyword%'
            ";

    return query($query);
    }
    
}

function getUserProfile($data) {
    global $conn;
    $query = "SELECT * FROM tb_user WHERE email = '$data' OR id_user = '$data'";
    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_assoc($result);

    return $row;
}

function editUserProfile($data, $uid, $img) {
    global $conn;

    $name = validateData($data['name']);
    $contact = validateNumber(validateData($data['kontak']));
    $address = validateData($data['alamat']);
    $latitude = $data['latitude'];
    $longitude = $data['longitude'];
    $oldImage = $data['old_profile'];

    //Check if user select new img profile
    if($img['error'] === 4) {
        $image = $oldImage;
    } else {
        $image = uploadImage($img);
    }

    if(!$image) {
        return false;
    }
    

    $query = "UPDATE tb_user SET nama_user = '$name', kontak = '$contact', alamat = '$address', latitude = '$latitude', longitude = '$longitude', image = '$image' WHERE id_user = '$uid'";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function uploadImage($img){
    $fileName = $img['name'];
    $sizeFile = $img['size'];
    $error = $img['error'];
    $tmpFile = $img['tmp_name'];

    //Check is there a valid image
    $validExtensionFile = ['jpg', 'jpeg', 'png', 'gif'];
    $extensionFile = explode('.', $fileName);
    $extensionFile = strtolower(end($extensionFile));

    if(!in_array($extensionFile, $validExtensionFile)) {
        echo "<script>alert('Mohon upload gambar yang valid')</script>";
        return false;
    }

    //Check if the file size is to large
    if($sizeFile > 2000000) {
        echo "<script>alert('Maksimal gambar beruukuran 2 MB')</script>";
        return false;
    }

    //Generate new file name
    $newFileName = date("dmY") . '_' . uniqid() . '.' . $extensionFile;


    //Move uploaded file to database
    $destination = '../img/profile/';

    move_uploaded_file($tmpFile, $destination . $newFileName);

    return $newFileName;


}

?>