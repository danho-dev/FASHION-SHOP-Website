<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('../model/connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mã hóa mật khẩu để so sánh với CSDL
    // Lưu ý: MD5 không còn được coi là an toàn. Bạn nên cân nhắc sử dụng password_hash() và password_verify() trong tương lai.
    $hashed_password = md5($password);

    // Sử dụng Prepared Statement để chống SQL Injection
    $sql = "SELECT id, username FROM users WHERE username = ? AND password = ? AND role = 1 LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        // Đăng nhập thành công
        $admin = mysqli_fetch_assoc($result);

        // Lưu thông tin admin vào session
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['admin_id'] = $admin['id'];

        // Chuyển hướng đến trang dashboard
        header("Location: index.php");
        exit();
    } else {
        // Đăng nhập thất bại
        $_SESSION['login_error'] = "Tên đăng nhập hoặc mật khẩu không đúng, hoặc bạn không có quyền truy cập.";
        header("Location: login.php");
        exit();
    }
} else {
    // Nếu không phải phương thức POST, chuyển về trang login
    header("Location: login.php");
    exit();
}