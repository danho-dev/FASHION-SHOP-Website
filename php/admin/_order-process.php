<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('../model/connect.php');

// --- Bảo vệ: Chỉ admin mới có quyền truy cập ---
if (!isset($_SESSION['admin_username'])) {
    $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Bạn không có quyền truy cập.'];
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $order_id = (int)$_POST['order_id'];
    $new_status = (int)$_POST['status'];

    if ($order_id > 0) {
        $sql = "UPDATE orders SET status = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $new_status, $order_id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Đã cập nhật trạng thái đơn hàng thành công!'];
        } else {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Cập nhật trạng thái thất bại.'];
        }
    }
    // Chuyển hướng trở lại trang chi tiết đơn hàng
    header("Location: order-detail.php?id=" . $order_id);
    exit();
}

// Nếu không phải yêu cầu hợp lệ, chuyển về trang danh sách đơn hàng
header("Location: orders.php");
exit();
?>