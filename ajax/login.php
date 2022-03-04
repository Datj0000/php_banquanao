<?php

$con = mysqli_connect("localhost", "root", "", "website_mvc");

if (isset($_POST['sigin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $result = $con->query("INSERT INTO tbl_customer(name,email,phone,password,address) VALUES('$name','$email','$phone','$password', '$address')");
    if ($result) {
        echo 1;
    } else {
        echo 0;
    }
}
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $check_login = "SELECT * FROM tbl_customer WHERE email='$email' AND password='$password'";
    $result_check = $con->query($check_login);
    if ($result_check) {
        $value = $result_check->fetch_assoc();
        Session::set('customer_login', true);
        Session::set('customer_id', $value['id']);
        Session::set('customer_name', $value['name']);
        header('location: trang-chu.html');
    } else {
       
    }
}
?>
