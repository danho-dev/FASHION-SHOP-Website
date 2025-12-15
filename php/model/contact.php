<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('connect.php');

// Xử lý thông báo (nên dùng session flash message để tối ưu hơn)
if (isset($_GET['cs'])) {
    echo "<script type=\"text/javascript\">alert(\"Gửi liên hệ thành công!\");</script>";
}
if (isset($_GET['cf'])) {
    echo "<script type=\"text/javascript\">alert(\"Gửi liên hệ thất bại!\");</script>";
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Liên Hệ - FASHION SHOP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../images/icon-logo.gif">
    <link rel="stylesheet" type="text/css" href="../../css/model.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <?php include("header.php"); ?>

    <main class="main-content">
        <div class="container">
            <div class="contact__container">
                <h1 class="contact__title">Thông Tin Liên Hệ</h1>
                <p class="contact__subtitle">Chúng tôi luôn sẵn sàng lắng nghe từ bạn. Vui lòng điền vào biểu mẫu bên dưới.</p>
                <form name="form-lien-he" action="_contact.php" method="POST" class="contact__form">
                    <div class="contact__form-grid">
                        <div class="contact__group">
                            <label for="contact-name" class="contact__label">Họ và tên <span class="contact__required">*</span></label>
                            <input type="text" id="contact-name" name="contact-name" placeholder="Nhập họ tên đầy đủ" class="contact__input" required>
                        </div>

                        <div class="contact__group">
                            <label for="contact-email" class="contact__label">Email <span class="contact__required">*</span></label>
                            <input type="email" id="contact-email" name="contact-email" placeholder="Nhập email của bạn" class="contact__input" required>
                        </div>
                    </div>
                    <div class="contact__group">
                        <label for="contact-subject" class="contact__label">Tiêu đề <span class="contact__required">*</span></label>
                        <input type="text" id="contact-subject" name="contact-subject" placeholder="Nhập tiêu đề" class="contact__input" required>
                    </div>
                    <div class="contact__group">
                        <label for="contact-content" class="contact__label">Nội dung <span class="contact__required">*</span></label>
                        <textarea id="contact-content" name="contact-content" placeholder="Nhập nội dung cần liên hệ..." class="contact__textarea" rows="6" required></textarea>
                    </div>
                    <div class="contact__button-wrapper">
                        <button type="submit" name="sendcontact" class="contact__button">Gửi Liên Hệ</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Google Maps -->
        <div class="contact__map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d958.5247181884388!2d108.24206672970746!3d16.060358250494478!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31421836ed15dfc9%3A0x99c3cc369a33576c!2sPasserelles+num%C3%A9riques+Vietnam!5e0!3m2!1sen!2s!4v1513938605489" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </main>

    <?php include("footer.php"); ?>
</body>

</html>