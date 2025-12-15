<?php
session_start();
// Nếu không có session tạm, đá về trang login
if (!isset($_SESSION['temp_login'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Xác thực đăng nhập - FASHION SHOP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../images/icon-logo.gif">
    <link rel="stylesheet" type="text/css" href="../../../css/model.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container">
        <div class="login-page">
            <form class="login-form" action="_verify_otp.php" method="post">
                <h1 class="login-form__title">Xác Thực Hai Bước</h1>
                
                <p style="text-align: center; margin-bottom: 20px;">
                    Chúng tôi đã gửi một mã xác thực đến email: <br>
                    <strong><?php echo substr($_SESSION['temp_login']['email'], 0, 3) . '***@***' . substr(strrchr($_SESSION['temp_login']['email'], "@"), 1); ?></strong>
                </p>

                <?php if(isset($_GET['error'])): ?>
                    <p style="color: red; text-align: center;">Mã xác thực không đúng hoặc đã hết hạn!</p>
                <?php endif; ?>

                <!-- <p style="color: blue; text-align: center;">(Test Localhost: <?php echo $_SESSION['temp_login']['otp']; ?>)</p> -->

                <div class="login-form__group">
                    <div class="login-form__input-wrapper">
                        <i class="fa fa-key login-form__icon"></i>
                        <input type="text" name="otp" class="login-form__input" placeholder="Nhập mã 6 số" required pattern="[0-9]{6}" title="Vui lòng nhập 6 chữ số" />
                    </div>
                </div>

                <button type="submit" name="verify" class="login-form__button">Xác nhận</button>
                
                <div class="login-form__footer">
                    <a href="login.php">Quay lại đăng nhập</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>