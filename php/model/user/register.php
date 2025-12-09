<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('../connect.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Đăng ký - FASHION SHOP</title>
    <link rel="icon" type="image/png" href="../../images/icon-logo.gif">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="../../../css/model.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="../../js/model.js"></script>
</head>

<body>
    <div class="container">
        <div class="register-page">
            <form class="register-form" action="_register.php" method="POST" name="myForm" onsubmit="return validateForm();">
                <h1 class="register-form__title">Đăng Ký Tài Khoản</h1>

                <div class="register-form__group">
                    <div class="register-form__input-wrapper">
                        <i class="fa fa-user-circle register-form__icon"></i>
                        <input type="text" class="register-form__input" name="fullname" placeholder="Họ và tên" required />
                    </div>
                </div>

                <div class="register-form__group">
                    <div class="register-form__input-wrapper">
                        <i class="fa fa-user register-form__icon"></i>
                        <input type="text" class="register-form__input" name="username" placeholder="Tên đăng nhập" required />
                    </div>
                </div>

                <div class="register-form__group">
                    <div class="register-form__input-wrapper">
                        <i class="fa fa-envelope register-form__icon"></i>
                        <input type="email" class="register-form__input" name="email" placeholder="Email" required />
                    </div>
                </div>

                <div class="register-form__group">
                    <div class="register-form__input-wrapper">
                        <i class="fa fa-phone register-form__icon"></i>
                        <input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" minlength="9" maxlength="11" class="register-form__input" name="phone" placeholder="Số điện thoại" required />
                    </div>
                </div>

                <div class="register-form__group">
                    <div class="register-form__input-wrapper">
                        <i class="fa fa-address-book register-form__icon"></i>
                        <input type="text" class="register-form__input" name="address" placeholder="Địa chỉ" required />
                    </div>
                </div>

                <div class="register-form__row">
                    <div class="register-form__group register-form__group--half">
                        <div class="register-form__input-wrapper">
                            <i class="fa fa-lock register-form__icon"></i>
                            <input type="password" class="register-form__input" name="password" placeholder="Mật khẩu" required />
                        </div>
                    </div>
                    <div class="register-form__group register-form__group--half">
                        <div class="register-form__input-wrapper">
                            <i class="fa fa-lock register-form__icon"></i>
                            <input type="password" class="register-form__input" name="confirmPassword" id="password_confirmation" placeholder="Nhập lại mật khẩu" required />
                        </div>
                    </div>
                </div>

                <button type="submit" class="register-form__button" name="submit">Đăng ký</button>

                <div class="register-form__footer">
                    <p>Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>