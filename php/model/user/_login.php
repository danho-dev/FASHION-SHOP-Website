<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL ^ E_DEPRECATED);
require_once('../connect.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $_SESSION['username'] = $username; // Initializing Session,Khởi tạo Session cho username
        $_SESSION['id-user'] = $row['id'];
        header("location:../index.php?ls=success");
        exit();
    } else {
        header("location:login.php?error=1");
        exit();
    }
} else {
    //    echo 'lala';
}
?>
