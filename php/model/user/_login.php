<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL ^ E_DEPRECATED);
require_once('../connect.php');
require_once('../send_mail.php'); // Import hàm gửi mail từ file vừa tạo

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // Sử dụng prepared statement để bảo mật hơn
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // 1. Tạo mã OTP ngẫu nhiên (6 chữ số)
        $otp = rand(100000, 999999);
        
        // 2. Lưu thông tin tạm thời vào Session (chưa cho đăng nhập chính thức)
        $_SESSION['temp_login'] = [
            'id' => $row['id'],
            'username' => $row['username'],
            'email' => $row['email'],
            'otp' => $otp,
            'otp_expiry' => time() + 300 // Mã hết hạn sau 5 phút
        ];

        // 3. Gửi email bằng PHPMailer
        $subject = "Mã xác thực đăng nhập - FASHION SHOP";
        // Nội dung HTML đẹp hơn
        $message = "<h3>Xin chào " . htmlspecialchars($row['fullname']) . ",</h3><p>Mã xác thực của bạn là: <b style='font-size: 20px; color: #e84393;'>" . $otp . "</b></p><p>Mã này sẽ hết hạn sau 5 phút.</p>";
        
        if (sendEmail($row['email'], $row['fullname'], $subject, $message)) {
            // 4. Chuyển hướng đến trang nhập mã OTP
            header("location:verify_otp.php");
            exit();
        } else {
            die("Lỗi gửi mail: Không thể gửi mã xác thực. Vui lòng thử lại sau hoặc liên hệ admin.");
        }
    } else {
        header("location:login.php?error=1"); // Chuyển hướng với thông báo lỗi
        exit();
    }
} else {
    //    echo 'lala';
}
?>
