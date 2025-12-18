<?php
session_start();
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../connect.php';

if (isset($_POST['submit'])) {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "INSERT INTO users (fullname, username, password, email, phone, address, role) VALUES (?, ?, ?, ?, ?, ?, 1)";
    $stmt = mysqli_prepare($conn, $sql);
    $password_hash = md5($password);
    mysqli_stmt_bind_param($stmt, "ssssss", $fullname, $username, $password_hash, $email, $phone, $address);
    
    if (mysqli_stmt_execute($stmt)) {
        header("location:login.php?rs=success");
        exit();
    } else {
        header("location:login.php?rf=fail");
        exit();
    }
}
