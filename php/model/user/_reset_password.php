<?php
session_start();
require_once '../connect.php';

if (isset($_POST['change_pass']) && isset($_SESSION['allow_change_pass'])) {
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];
    $user_id = $_SESSION['allow_change_pass'];

    if ($new_pass !== $confirm_pass) {
        header("Location: reset_password.php?error=Mật khẩu nhập lại không khớp!");
        exit();
    }

    // Mã hóa mật khẩu (MD5) để khớp với hệ thống hiện tại
    $hashed_pass = md5($new_pass);

    $sql = "UPDATE users SET password = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $hashed_pass, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        // Xóa quyền đổi mật khẩu
        unset($_SESSION['allow_change_pass']);
        
        // Thông báo và về trang login
        echo "<script>alert('Đổi mật khẩu thành công! Vui lòng đăng nhập lại.'); window.location.href='login.php';</script>";
    } else {
        header("Location: reset_password.php?error=Lỗi hệ thống, vui lòng thử lại!");
    }
} else {
    header("Location: login.php");
    exit();
}
?>