<?php
session_start();

if (isset($_POST['verify']) && isset($_SESSION['temp_login'])) {
    $entered_otp = $_POST['otp'];
    $stored_otp = $_SESSION['temp_login']['otp'];
    $expiry = $_SESSION['temp_login']['otp_expiry'];

    // Kiểm tra mã OTP và thời gian hết hạn
    if ($entered_otp == $stored_otp && time() <= $expiry) {
        // --- XÁC THỰC THÀNH CÔNG ---
        
        // 1. Chuyển session tạm thành session chính thức
        $_SESSION['username'] = $_SESSION['temp_login']['username'];
        $_SESSION['id-user'] = $_SESSION['temp_login']['id'];
        
        // 2. Xóa session tạm
        unset($_SESSION['temp_login']);
        
        // 3. Chuyển hướng vào trang chủ
        header("Location: ../index.php?ls=success");
        exit();
    } else {
        // Mã sai hoặc hết hạn
        header("Location: verify_otp.php?error=1");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>