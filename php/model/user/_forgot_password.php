<?php
session_start();
require_once '../connect.php';
require_once '../send_mail.php';

if (isset($_POST['submit_forgot'])) {
    $input = trim($_POST['username_or_email']);

    // Kiểm tra user tồn tại (bằng email hoặc username)
    $sql = "SELECT * FROM users WHERE email = ? OR username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $input, $input);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Tạo OTP
        $otp = rand(100000, 999999);
        
        // Lưu thông tin vào session tạm để verify
        $_SESSION['temp_reset'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'fullname' => $user['fullname'],
            'otp' => $otp,
            'expire_time' => time() + 300 // Hết hạn sau 5 phút
        ];

        // Gửi mail
        $subject = "Mã xác thực khôi phục mật khẩu";
        $content = "Chào " . $user['fullname'] . ",<br>Mã OTP khôi phục mật khẩu của bạn là: <b style='font-size:20px;color:blue;'>$otp</b>.<br>Mã này có hiệu lực trong 5 phút.";
        
        if (sendEmail($user['email'], $user['fullname'], $subject, $content)) {
            header("Location: verify_reset_otp.php");
            exit();
        } else {
            $error = "Không thể gửi email. Vui lòng thử lại sau.";
            header("Location: forgot_password.php?error=" . urlencode($error));
            exit();
        }
    } else {
        $error = "Không tìm thấy tài khoản với thông tin này.";
        header("Location: forgot_password.php?error=" . urlencode($error));
        exit();
    }
} else {
    header("Location: forgot_password.php");
    exit();
}
?>