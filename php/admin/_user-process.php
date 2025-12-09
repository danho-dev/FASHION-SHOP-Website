<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('../model/connect.php');

// Chỉ admin mới có quyền thực hiện
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['action'])) {
    $user_id = (int)$_GET['id'];
    $action = $_GET['action'];

    $new_level = null;
    if ($action === 'block') {
        $new_level = 2; // Cấp độ cho tài khoản bị khóa
        $message = "Đã khóa tài khoản thành công.";
    } elseif ($action === 'unblock') {
        $new_level = 0; // Cấp độ cho tài khoản thường
        $message = "Đã mở khóa tài khoản thành công.";
    }

    if ($new_level !== null && $user_id > 0) {
        $sql = "UPDATE users SET role = ? WHERE id = ? AND role != 1"; // Không cho phép thay đổi role của admin khác
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $new_level, $user_id);
        
        if (mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) > 0) {
            $_SESSION['flash_message'] = ['type' => 'success', 'text' => $message];
        } else {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Thao tác thất bại hoặc bạn không có quyền thay đổi tài khoản này.'];
        }
    }
}

header("Location: users.php");
exit();