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

    $is_ok = false;
    $msg = '';

    if(!isset($data['name']) || !is_string($data['name'])) {
        $msg = "Nama tidak boleh kosong!";
        goto out;
    }

    if(!isset($data['email']) || !is_string($data['email'])) {
        $msg = "Email tidak boleh kosong!";
        goto out;
    }

    if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $msg = "Email {$data['email']} tidak tidak valid!";
        goto out;
    }

    //check if email is already use or not
    $email = $data['email'];
    $result = mysqli_query($conn, "SELECT email FROM tb_laundry WHERE email = '$email'");
    if(mysqli_fetch_assoc($result)){
        $msg = "Email sudah terdaftar!";
        goto out;
    }

    if(!isset($data['password']) || !is_string($data['password'])) {
        $msg = "Kata sandi tidak boleh kosong!";
        goto out;
    }

    if(strlen($data['password']) < 8) {
        $msg = "Kata sandi harus minimal 8 karakter!";
        goto out;
    }

    if(!preg_match("/\d/", $data['password']) || 
        !preg_match("/[A-Z]/", $data['password']) || 
        !preg_match("/[a-z]/", $data['password'])) {
            $msg = "Kata sandi harus terdiri dari angka, huruf besar dan huruf kecil!";
            goto out;
        }
    
    if(!isset($data['confirm']) || !is_string($data['confirm'])) {
        $msg = "Konfirmasi kata sandi tidak boleh kosong!";
        goto out;
    }

    if($data['password'] !== $data['confirm']) {
        $msg = "Kata sandi tidak sesuai!";
        goto out;
    }

    if(!isset($data['kontak'])) {
        $msg = "Kontak tidak boleh kosong!";
        goto out;
    }
    
    if(!is_numeric($data['kontak'])) {
        $msg = "Kontak tidak valid!";
        goto out;
    }

    if(!isset($data['biaya']) || !is_numeric($data['biaya'])) {
        $msg = "Biaya tidak valid!";
        goto out; 
    }

    // Check validation on start and end day
    if(!validateWorkingDay($data['hari_mulai'], $data['hari_akhir'])) {
        $msg = "Hari kerja tidak valid!";
        goto out;
    }

    // Check validate open and close time
    if(!validateWorkingTime($data['open_time'], $data['close_time'])){
        $msg = "Jam kerja tidak valid!";
        goto out;
    }

    if(strlen($data['alamat']) < 1 || !is_string($data['alamat'])) {
        $msg = "Alamat tidak boleh kosong!";
        goto out;  
    }

    if(!isset($data['term'])){
        $msg = "Harap menyetujui syarat & ketentuan!";
        goto out; 
    }




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

    //encrypt password
    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO tb_laundry VALUES('', '$name', '$email', '$password', '$alamat', '$latitude', '$longitude', '$biaya', '$kontak', '$jenis', '$hari_mulai', '$hari_akhir', '$open_time', '$close_time', '')";
    mysqli_query($conn, $query);
    $is_ok = true;
    $msg = "Berhasil mendaftarkan laundry!";
    

    // return mysqli_affected_rows($conn);
    out:
        return[
            "is_ok" => $is_ok,
            "msg" => $msg,
        ];
}

function loginLaundry($data){
    global $conn;

    $is_ok = false;
    $msg = '';

    if(!empty($data['email'])) {
        if(!empty($data['password'])) {

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
                    $is_ok = true;
                    $_SESSION['admin'] = $email;
                    header('location: index.php');
                    exit;
                } else {
                    $msg = 'Password salah!';
                    goto out;
                }
            } else {
                $msg = 'Email tidak ditemukan!';
                goto out;
            }

        } else {
            $msg = 'Password tidak boleh kosong!';
            goto out;
        }
    } else {
        $msg = 'Email tidak boleh kosong!';
        goto out;
    }

    out: 
        return [
            "is_ok" => $is_ok,
            "msg" => $msg,
        ];
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

function getLaundryProfile($email) {
    global $conn;

    $query = "SELECT * FROM tb_laundry WHERE email = '$email'";

    $result = mysqli_query($conn, $query);

    return mysqli_fetch_assoc($result);
}

function getTotalOrders($email) {
    global $conn;

    $result = mysqli_query($conn, "SELECT id_laundry FROM tb_laundry WHERE email = '$email'");
    $laundry = mysqli_fetch_assoc($result);

    $id_laundry = (int) $laundry['id_laundry'];

    $data = query("SELECT * FROM tb_order WHERE id_laundry = '$id_laundry'");

    return $data;    
}

function getAllTransactions($email) {
    global $conn;

    $result = mysqli_query($conn, "SELECT id_laundry FROM tb_laundry WHERE email = '$email'");
    $laundry = mysqli_fetch_assoc($result);

    $id_laundry = (int) $laundry['id_laundry'];

    $data = query("SELECT * FROM tb_order 
                    INNER JOIN tb_transaksi ON tb_transaksi.id_order = tb_order.id_order 
                    INNER JOIN tb_laundry ON tb_laundry.id_laundry = tb_order.id_laundry 
                    INNER JOIN tb_user ON tb_user.id_user = tb_order.id_user
                    WHERE tb_order.id_laundry = '$id_laundry' ORDER BY tb_transaksi.id_transaksi");


    return $data;    
}

function countCustomer($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();

    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}

function countOrder($email, $status) {
    global $conn;

    $result = mysqli_query($conn, "SELECT id_laundry FROM tb_laundry WHERE email = '$email'");
    $laundry = mysqli_fetch_assoc($result);

    $id_laundry = (int) $laundry['id_laundry'];

    $data = query("SELECT * FROM tb_order WHERE id_laundry = '$id_laundry' AND status = '$status'");

    return $data;  

}

?>