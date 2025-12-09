<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL ^ E_DEPRECATED);
require_once('../connect.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // Sử dụng prepared statement để bảo mật hơn
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $result = mysqli_query($conn, $sql);
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $username; // Initializing Session,Khởi tạo Session cho username
        $_SESSION['id-user'] = $row['id'];
        header("location:../index.php?ls=success");
        exit();
    } else {
        header("location:login.php?error=1"); // Chuyển hướng với thông báo lỗi
        exit();
    }
} else {
    //    echo 'lala';
}
?>
