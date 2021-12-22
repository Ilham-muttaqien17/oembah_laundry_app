<?php 

$conn = mysqli_connect("localhost", "root", "", "db_oembah");

function validateData($data) {
    global $conn;
    $data = mysqli_real_escape_string($conn, $data);

    return $data;
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

    $numberValidated = '';

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

function registerLaundry($data) {
    global $conn;
    $name = validateData($data['name']);
    $email = validateData($data['email']);
    $password = validateData($data['password']);
    $confirm = validateData($data['confirm']);
    $alamat = validateData($data['alamat']);
    $latitude = $data['latitude'];
    $longitude = $data['longitude'];
    $biaya = $data['biaya'];
    $kontak = validateNumber(validateData($data['kontak']));   
    $jenis = $data['jenis'];
    $hari_mulai = $data['hari_mulai'];
    $hari_akhir = $data['hari_akhir'];
    $open_time = $data['open_time'];
    $close_time = $data['close_time'];

    //check if email is already use or not
    $result = mysqli_query($conn, "SELECT email FROM tb_laundry WHERE email = '$email'");
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

    // Check validation on start and end day
    if(!validateWorkingDay($hari_mulai, $hari_akhir)) {
        return false;
    }

    // Check validate open and close time
    if(!validateWorkingTime($open_time, $close_time)){
        return false;
    }

    //insert data to database
    $query = "INSERT INTO tb_laundry VALUES('', '$name', '$email', '$password', '$alamat', '$latitude', '$longitude', '$biaya', '$kontak', '$jenis', '$hari_mulai', '$hari_akhir', '$open_time', '$close_time', '')";
    mysqli_query($conn, $query);
    

    return mysqli_affected_rows($conn);
}

function loginLaundry($data){
    global $conn;
    $email = validateData($data['email']);
    $password = validateData($data['password']);

    $result = mysqli_query($conn, "SELECT * FROM tb_laundry WHERE email = '$email'");

    if(mysqli_num_rows($result) === 1) {
        //get all data from result
        $row = mysqli_fetch_assoc($result);

        //check password 
        if(password_verify($password, $row['password'])) {
            if(isset($data['rememberme'])) {
                setcookie("admin_email", $email, time() + (10 * 365 * 24 * 60 * 60));
            }
            $_SESSION['admin'] = true;
            header('location: index.php');
            exit;
        } 
    }

    return false;
}

function checkCookie($cookie){
    global $conn;
    if(isset($cookie['admin_email'])){
        $email = $cookie['admin_email'];
        $result = mysqli_query($conn, "SELECT * FROM tb_laundry WHERE email = '$email'");
        $row = mysqli_fetch_assoc($result);
        if($cookie['admin_email'] == $row['email']){
            return true;
        }
    }

    return false;
    
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

function confirmOrderIn($idOrder) {
    global $conn;

    $result = mysqli_query($conn, "SELECT * FROM tb_order WHERE id_order='$idOrder'");
    $row = mysqli_fetch_assoc($result);
    $oid = $row['id_order'];

    $order_id = $oid;

    mysqli_query($conn, "UPDATE tb_order SET status = 2 WHERE id_order = '$order_id'");
    mysqli_query($conn, "UPDATE tb_transaksi SET status_transaksi = 3 WHERE id_order = '$order_id'");

    return mysqli_affected_rows($conn);
}

function processOrderIn($idOrder) {
    global $conn;

    $result = mysqli_query($conn, "SELECT * FROM tb_order WHERE id_order='$idOrder'");
    $row = mysqli_fetch_assoc($result);
    $oid = $row['id_order'];

    $order_id = $oid;

    mysqli_query($conn, "UPDATE tb_order SET status = 3 WHERE id_order = '$order_id'");

    return mysqli_affected_rows($conn);
}

function sendOrderIn($idOrder) {
    global $conn;

    $result = mysqli_query($conn, "SELECT * FROM tb_order WHERE id_order='$idOrder'");
    $row = mysqli_fetch_assoc($result);
    $oid = $row['id_order'];

    $order_id = $oid;

    mysqli_query($conn, "UPDATE tb_order SET status = 4 WHERE id_order = '$order_id'");

    return mysqli_affected_rows($conn);
}

function checkUser($data) {
    global $conn;

    $result = mysqli_query($conn, "SELECT * FROM tb_laundry WHERE email = '$data' ");
    $row = mysqli_fetch_assoc($result);

    $lid = (int) $row['id_laundry'];

    return $lid;
}

function getUserName($data){
    global $conn;
    $data = (int) $data;

    $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE id_user = '$data'");
    $row = mysqli_fetch_assoc($result);

    $lid = $row['nama_user'];

    return $lid;
}

function rejectOrder($reject_id) {
    global $conn;
    $oid = $reject_id;
    var_dump($oid);

    mysqli_query($conn, "UPDATE tb_transaksi SET status_transaksi = 1 WHERE id_order = '$oid'");

    mysqli_query($conn, "UPDATE tb_order SET status = 6 WHERE id_order = '$oid'");

    return mysqli_affected_rows($conn);
}

function getContactUser($data){
    global $conn;
    $data = (int) $data;
    
    $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE id_user = '$data'");
    $row = mysqli_fetch_assoc($result);

    $lid = $row['kontak'];

    return $lid;
}

function getUserPosition($data){
    global $conn;
    $data = (int) $data;
    
    $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE id_user = '$data'");
    $row = mysqli_fetch_assoc($result);

    return $row;
}

function validateWorkingTime($startTime, $endTime) {
    $startTime = explode (':', $startTime);
    $startHour = reset($startTime);
    $startMinute = end($startTime);
    
    $endTime = explode(':', $endTime);
    $endHour = reset($endTime);
    $endMinute = end($endTime);

    $endTime = floatval($endHour . '.' . $endMinute);
    $startTime = floatval($startHour . '.' . $startMinute);
    
    $countTime = $endTime - $startTime;

    if($countTime <= 0) {
        return false;
    } 

    return true;
}

function validateWorkingDay($startDay, $endDay) {

    $day = array(
        "Senin" => 1,
        "Selasa" => 2,
        "Rabu" => 3,
        "Kamis" => 4,
        "Jumat" => 5,
        "Sabtu" => 6,
        "Minggu" => 7
    );

    $startDay = $day[$startDay];
    $endDay = $day[$endDay];
    $count = $endDay - $startDay;

    if($count <= 0) {
        return false;
    }

    return true;
}


?>