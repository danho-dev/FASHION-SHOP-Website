<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('../connect.php');

// Xử lý các thông báo
$alert_message = '';
if (isset($_GET['error'])) {
    $alert_message = "Vui lòng kiểm tra lại tài khoản hoặc mật khẩu của bạn!";
} elseif (isset($_GET['rs']) && $_GET['rs'] == 'success') {
    $alert_message = "Bạn đã đăng ký thành công! Vui lòng đăng nhập để tiếp tục.";
} elseif (isset($_GET['rf']) && $_GET['rf'] == 'fail') {
    $alert_message = "Đăng ký thất bại, vui lòng thử lại!";
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Đăng nhập - FASHION SHOP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../images/icon-logo.gif">
    <link rel="stylesheet" type="text/css" href="../../../css/model.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="../../js/model.js"></script>
</head>

<body>
    <?php if (!empty($alert_message)) : ?>
        <script type="text/javascript">
            alert("<?php echo $alert_message; ?>");
        </script>
    <?php endif; ?>

    <div class="container">
        <div class="login-page">
            <form class="login-form" action="_login.php" method="post">
                <h1 class="login-form__title">Đăng Nhập Tài Khoản</h1>

                <div class="login-form__group">
                    <div class="login-form__input-wrapper">
                        <i class="fa fa-user login-form__icon"></i>
                        <input type="text" name="username" class="login-form__input" placeholder="Tên đăng nhập" required />
                    </div>
                </div>

                <div class="login-form__group">
                    <div class="login-form__input-wrapper">
                        <i class="fa fa-lock login-form__icon"></i>
                        <input type="password" name="password" class="login-form__input" placeholder="Mật khẩu" required />
                    </div>
                </div>

                <button type="submit" name="submit" class="login-form__button">Đăng nhập</button>

                <div class="login-form__footer">
                    <p>Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>