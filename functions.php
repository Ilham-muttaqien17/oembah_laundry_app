<?php 

$conn = mysqli_connect("localhost", "root", "", "db_oembah");

function validateData($data) {
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

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

function registerUser($data) {
    global $conn;
    $name = validateData($data['name']);
    $email = validateData($data['email']);
    $password = validateData($data['password']);
    $confirm = validateData($data['confirm']);

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
    $query = "INSERT INTO tb_user VALUES('', '$name', '$email', '$password', '', '')";
    mysqli_query($conn, $query);
    

    return mysqli_affected_rows($conn);
}

function loginUser($data){
    global $conn;
    $email = $data['email'];
    $password = $data['password'];

    $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE email = '$email'");

    if(mysqli_num_rows($result) === 1) {
        //get all data from result
        $row = mysqli_fetch_assoc($result);

        //check password 
        if(password_verify($password, $row['password'])) {
            setcookie("user_email", $email, time() + 3600);
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
    mysqli_query($conn, "UPDATE tb_transaksi SET status = 4 WHERE id_order = '$oid'");

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

?>