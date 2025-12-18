<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Quên mật khẩu - FASHION SHOP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../images/icon-logo.gif">
    <link rel="stylesheet" type="text/css" href="../../../css/model.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container">
        <div class="login-page">
            <form class="login-form" action="_forgot_password.php" method="post">
                <h1 class="login-form__title">Quên Mật Khẩu</h1>
                <p style="text-align: center; margin-bottom: 20px;">
                    Nhập email hoặc tên đăng nhập của bạn để tìm kiếm tài khoản.
                </p>

                <?php if(isset($_GET['error'])): ?>
                    <p style="color: red; text-align: center;"><?php echo htmlspecialchars($_GET['error']); ?></p>
                <?php endif; ?>

                <div class="login-form__group">
                    <div class="login-form__input-wrapper">
                        <i class="fa fa-user login-form__icon"></i>
                        <input type="text" name="username_or_email" class="login-form__input" placeholder="Email hoặc Tên đăng nhập" required />
                    </div>
                </div>

                <button type="submit" name="submit_forgot" class="login-form__button">Tiếp tục</button>
                
                <div class="login-form__footer">
                    <a href="login.php">Quay lại đăng nhập</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>