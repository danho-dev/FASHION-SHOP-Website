<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Xóa các biến session cụ thể của người dùng
unset($_SESSION['username']);
unset($_SESSION['id-user']);
unset($_SESSION['cart']); // **Quan trọng: Xóa giỏ hàng**

// Chuyển hướng người dùng về trang chủ
header("Location: ../index.php");
exit();
?>