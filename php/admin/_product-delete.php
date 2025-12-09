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

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Lấy đường dẫn ảnh để xóa file
    $sql_select = "SELECT image FROM products WHERE id = ?";
    $stmt_select = mysqli_prepare($conn, $sql_select);
    mysqli_stmt_bind_param($stmt_select, "i", $id);
    mysqli_stmt_execute($stmt_select);
    $result_select = mysqli_stmt_get_result($stmt_select);
    if ($row = mysqli_fetch_assoc($result_select)) {
        $image_path = "../../" . $row['image'];
        if (file_exists($image_path) && !is_dir($image_path)) {
            unlink($image_path); // Xóa file ảnh
        }
    }

    // Xóa bản ghi trong CSDL
    $sql_delete = "DELETE FROM products WHERE id = ?";
    $stmt_delete = mysqli_prepare($conn, $sql_delete);
    mysqli_stmt_bind_param($stmt_delete, "i", $id);

    if (mysqli_stmt_execute($stmt_delete)) {
        $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Đã xóa sản phẩm thành công!'];
    } else {
        $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Xóa sản phẩm thất bại.'];
    }
}

header("Location: products.php");
exit();
?>