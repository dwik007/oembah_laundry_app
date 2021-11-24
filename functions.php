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
            setcookie("email", $email, time() + 3600);
            $_SESSION['login'] = true;
            header('location: index.php');
            exit;
        } 
    }

    return false;
}

function checkCookie($cookie){
    global $conn;
    if(isset($cookie['email'])){
        $email = $cookie['email'];
        $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE email = '$email'");
        $row = mysqli_fetch_assoc($result);
        if($cookie['email'] == $row['email']){
            return true;
        }
    }

    return false;
    
}

function getDetailLaundry($data){
    global $conn;

    //convert string to int
    $cek = trim($data,'\'');
    $id_laundry = (int) $cek;
    $result = mysqli_query($conn, "SELECT * FROM tb_laundry WHERE id_laundry = '$id_laundry'");

    $row = mysqli_fetch_assoc($result);

    // var_dump($row);
    return $row;
}

?>