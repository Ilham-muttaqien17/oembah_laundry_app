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

function registerUser($data) {
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
    $result = mysqli_query($conn, "SELECT email FROM tb_user WHERE email = '$email'");
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
    $contact = validateNumber(validateData($data['kontak']));
    $address = validateData($data['alamat']);
    $latitude = $data['latitude'];
    $longitude = $data['longitude'];
    

    //encrypt password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //insert data to database
    $query = "INSERT INTO tb_user VALUES('', '$name', '$email', '$password', '$address', '$latitude', '$longitude', '$contact', '')";
    mysqli_query($conn, $query);
    $is_ok = true;
    $msg = "Berhasil mendaftarkan akun!";
    

    // return mysqli_affected_rows($conn);

    out: return [
        "is_ok" => $is_ok,
        "msg" => $msg,
    ];
}

function loginUser($data){
    global $conn;

    $msg = '';
    $is_ok = false;

    if(!empty($data['email'])) {
        if(!empty($data['password'])) {

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
                    $is_ok = true;
                    $_SESSION['user'] = $email;
                    header('location: index.php');
                    exit;
                } else {
                    $msg = "Password salah!";
                    goto out;
                }
            } else {
                $msg = "Email tidak ditemukan!";
                goto out;
            }
        } else {
            $msg = "Password tidak boleh kosong!";
            goto out;
        }
    } else {
        $msg = "Email tidak boleh kosong!";
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

function addOrder($email, $idLaundry, $jumlah, $tgl_order){
    global $conn;
    

    $query1 = mysqli_query($conn, "SELECT * FROM tb_user WHERE email = '$email'");
    $row1 = mysqli_fetch_assoc($query1);
    $userId = $row1['id_user'];

    $id_laundry = (int) $idLaundry;
    $id_user = (int) $userId;
    $qty = $jumlah;
    $status = 1;
    $order_time = $tgl_order;

    mysqli_query($conn, "INSERT INTO tb_order VALUES('', '$qty', '$status', '$order_time', '$id_user', '$id_laundry')");

    
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
    $password = validateData($data['password']);
    $contact = validateNumber(validateData($data['kontak']));
    $address = validateData($data['alamat']);
    $latitude = $data['latitude'];
    $longitude = $data['longitude'];
    $oldImage = $data['old_profile'];

    $msg = '';
    $query = '';
    $is_ok = false;

    //Check if user select new img profile
    if($img['error'] === 4) {
        $image = $oldImage;
    } else {
        $image = uploadImage($img);
        if(!$image) {
            $msg = "Hanya diperbolehkan upload gambar dalam format JPG, JPEG, PNG & GIF";
            goto out;
        }
    }

    // check password is empty
    if(empty($password)) {
        $query = "UPDATE tb_user SET nama_user = '$name', kontak = '$contact', alamat = '$address', latitude = '$latitude', longitude = '$longitude', image = '$image' WHERE id_user = '$uid'";
    } else {
        //encrypt password
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = "UPDATE tb_user SET nama_user = '$name', password = '$password', kontak = '$contact', alamat = '$address', latitude = '$latitude', longitude = '$longitude', image = '$image' WHERE id_user = '$uid'";
    }     

    mysqli_query($conn, $query);

    if(mysqli_affected_rows($conn) > 0) {
        $msg = "Berhasil mengubah data";
        $is_ok = true;
        goto out;
    } else {
        $msg = "Tidak ada data yang berubah";
        goto out;
    }

    out: 
        return [
            "msg" => $msg, 
            "is_ok" => $is_ok
        ];
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

function deleteUser($uid) {
    global $conn;
    $query = "DELETE FROM tb_user WHERE id_user = '$uid'";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

?>