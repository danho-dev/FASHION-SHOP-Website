<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra xem admin đã đăng nhập chưa
// Giả sử bạn lưu tên admin trong $_SESSION['admin_username']
if (!isset($_SESSION['admin_username']) && basename($_SERVER['PHP_SELF']) != 'login.php') {
    // Kích hoạt lại để bảo vệ trang admin
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

<header class="header">
    <div class="header__main-container container">
        <div class="header__logo">
            <a href="index.php" title="MyLiShop Admin"> <img src="../../images/logohong.png"> </a>
        </div>
        <div class="header__account-section">
            <div class="header__account-info-row">
                <i class="fa fa-user-secret fa-lg"></i>
                <span><?php echo $_SESSION['admin_username'] ?? 'Admin'; ?></span> &nbsp;
                <a href="../model/index.php" target="_blank"><i class="fa fa-eye"></i> Xem trang web</a> &nbsp;
                <a href="logout.php"><i class="fa fa-sign-out"></i> Đăng xuất</a>
            </div>
        </div>
    </div>
    <nav class="header__navbar">
        <div class="header__navbar-container container">
            <ul class="header__navbar-links">
                <li><a href="index.php">Tổng Quan</a></li>
                <li><a href="products.php">Sản Phẩm</a></li>
                <li><a href="categories.php">Danh Mục</a></li>
                <li><a href="orders.php">Đơn Hàng</a></li>
                <li><a href="users.php">Người Dùng</a></li>
                <li><a href="contacts.php">Liên Hệ</a></li>
                <li><a href="slides.php">Slideshow</a></li>
            </ul>
        </div>
    </nav>
</header>
