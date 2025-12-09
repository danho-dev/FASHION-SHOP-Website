<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Nếu admin đã đăng nhập, chuyển hướng đến trang dashboard
if (isset($_SESSION['admin_username'])) {
    header("Location: index.php");
    exit();
}

$error_message = '';
if (isset($_SESSION['login_error'])) {
    $error_message = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập Quản Trị</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="login__body">
    <div class="login__container">
        <form action="_login-process.php" method="POST" class="login__form">
            <h1 class="login__title">Đăng Nhập Admin</h1>
            <?php if ($error_message) : ?>
                <div class="login__error-message"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            <div class="login__group">
                <label for="username" class="login__label">Tên đăng nhập</label>
                <input type="text" id="username" name="username" class="login__input" required>
            </div>
            <div class="login__group">
                <label for="password" class="login__label">Mật khẩu</label>
                <input type="password" id="password" name="password" class="login__input" required>
            </div>
            <button type="submit" class="login__button">Đăng nhập</button>
        </form>
    </div>
</body>
</html>