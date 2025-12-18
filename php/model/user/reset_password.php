<?php
session_start();
// Chặn truy cập nếu chưa verify OTP thành công
if (!isset($_SESSION['allow_change_pass'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Đặt lại mật khẩu - FASHION SHOP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../images/icon-logo.gif">
    <link rel="stylesheet" type="text/css" href="../../../css/model.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container">
        <div class="login-page">
            <form class="login-form" action="_reset_password.php" method="post">
                <h1 class="login-form__title">Đặt Lại Mật Khẩu</h1>
                
                <?php if(isset($_GET['error'])): ?>
                    <p style="color: red; text-align: center;"><?php echo htmlspecialchars($_GET['error']); ?></p>
                <?php endif; ?>

                <div class="login-form__group">
                    <div class="login-form__input-wrapper">
                        <i class="fa fa-lock login-form__icon"></i>
                        <input type="password" name="new_password" class="login-form__input" placeholder="Mật khẩu mới" required minlength="6"/>
                    </div>
                </div>

                <div class="login-form__group">
                    <div class="login-form__input-wrapper">
                        <i class="fa fa-lock login-form__icon"></i>
                        <input type="password" name="confirm_password" class="login-form__input" placeholder="Nhập lại mật khẩu mới" required />
                    </div>
                </div>

                <button type="submit" name="change_pass" class="login-form__button">Đổi mật khẩu</button>
            </form>
        </div>
    </div>
</body>
</html>