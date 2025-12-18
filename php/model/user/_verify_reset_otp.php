<?php
session_start();

if (isset($_POST['verify_reset']) && isset($_SESSION['temp_reset'])) {
    $user_otp = $_POST['otp'];
    $session_otp = $_SESSION['temp_reset']['otp'];
    $expire_time = $_SESSION['temp_reset']['expire_time'];

    if (time() > $expire_time) {
        header("Location: verify_reset_otp.php?error=Mã xác thực đã hết hạn!");
        exit();
    }

    if ($user_otp == $session_otp) {
        // OTP đúng, cấp quyền đổi mật khẩu
        $_SESSION['allow_change_pass'] = $_SESSION['temp_reset']['id'];
        
        // Xóa session tạm
        unset($_SESSION['temp_reset']);
        
        header("Location: reset_password.php");
        exit();
    } else {
        header("Location: verify_reset_otp.php?error=Mã xác thực không đúng!");
        exit();
    }
} else {
    header("Location: forgot_password.php");
    exit();
}
?>