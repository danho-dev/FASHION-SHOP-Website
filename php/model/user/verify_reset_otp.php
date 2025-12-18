<?php
session_start();
if (!isset($_SESSION['temp_reset'])) {
    header("Location: forgot_password.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Xác thực OTP - FASHION SHOP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../images/icon-logo.gif">
    <link rel="stylesheet" type="text/css" href="../../../css/model.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container">
        <div class="login-page">
            <form class="login-form" action="_verify_reset_otp.php" method="post">
                <h1 class="login-form__title">Nhập Mã Xác Thực</h1>
                
                <p style="text-align: center; margin-bottom: 20px;">
                    Mã OTP đã được gửi đến: <br>
                    <strong><?php echo substr($_SESSION['temp_reset']['email'], 0, 3) . '***@***' . substr(strrchr($_SESSION['temp_reset']['email'], "@"), 1); ?></strong>
                </p>

                <?php if(isset($_GET['error'])): ?>
                    <p style="color: red; text-align: center;"><?php echo htmlspecialchars($_GET['error']); ?></p>
                <?php endif; ?>

                <!-- Hiển thị OTP để test localhost -->
                <p style="color: blue; text-align: center;">(Test Localhost: <?php echo $_SESSION['temp_reset']['otp']; ?>)</p>

                <div class="login-form__group">
                    <div class="login-form__input-wrapper">
                        <i class="fa fa-key login-form__icon"></i>
                        <input type="text" name="otp" class="login-form__input" placeholder="Nhập mã 6 số" required pattern="[0-9]{6}" title="Vui lòng nhập 6 chữ số" />
                    </div>
                </div>

                <button type="submit" name="verify_reset" class="login-form__button">Xác nhận</button>
                
                <div class="login-form__footer">
                    <a href="forgot_password.php">Gửi lại mã</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>