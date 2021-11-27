<?php 

$conn = mysqli_connect("localhost", "root", "", "db_oembah");

function validateData($data) {
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

function registerLaundry($data) {
    global $conn;
    $name = validateData($data['name']);
    $email = validateData($data['email']);
    $password = validateData($data['password']);
    $confirm = validateData($data['confirm']);
    $alamat = validateData($data['alamat']);
    $biaya = $data['biaya'];
    $kontak = validateData($data['kontak']);
    $jenis = $data['jenis'];
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

    //insert data to database
    $query = "INSERT INTO tb_laundry VALUES('', '$name', '$email', '$password', '$alamat', '$biaya', '$kontak', '$jenis', '$open_time', '$close_time')";
    mysqli_query($conn, $query);
    

    return mysqli_affected_rows($conn);
}

function loginLaundry($data){
    global $conn;
    $email = $data['email'];
    $password = $data['password'];

    $result = mysqli_query($conn, "SELECT * FROM tb_laundry WHERE email = '$email'");

    if(mysqli_num_rows($result) === 1) {
        //get all data from result
        $row = mysqli_fetch_assoc($result);

        //check password 
        if(password_verify($password, $row['password'])) {
            setcookie("admin_email", $email, time() + 3600);
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


?>