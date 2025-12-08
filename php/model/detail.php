<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Chi tiết sản phẩm - FASHION SHOP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../images/icon-logo.gif">
    <link rel="stylesheet" type="text/css" href="../../css/model.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="../../js/model.js"></script>
    <!-- Swiper.js -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</head>
<body>
    <!-- button top -->
    <!-- <a href="#" class="back-to-top"><i class="fa fa-arrow-up"></i></a> -->
    
<?php
    require_once("connect.php");
    include 'header.php';
    error_reporting(2);

    $sql = "SELECT * FROM products WHERE id = " . $_GET['id'];
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $thum_Image = $row['image'];
    }
?>
    <div class="container">
        <div class="detail">
            <div class="detail__main">
                <div class="detail__image-column">
                    <img class="detail__image" src="<?php echo "../../".$thum_Image; ?>" alt="<?php echo $row['name']; ?>">
                </div>
                <div class="detail__info-column">
                    <h1 class="detail__name"><?php echo $row['name']; ?></h1>
                    <hr class="detail__divider">
                    <div class="detail__price-section">
                        <?php
                            if ($row['saleprice'] > 0)
                            {
                                $gia = $row['price'] - ($row['price'] * $row['saleprice'] / 100);
                        ?>
                            <p class="detail__price--old">Giá cũ: <del><?php echo number_format($row['price']); ?> đ</del></p>
                            <p class="detail__price--current">Giá giảm còn: <?php echo number_format($gia); ?> đ</p>
                        <?php
                            } else
                            {
                        ?>
                                <p class="detail__price--current">Giá sản phẩm: <?php echo number_format($row['price']); ?> đ</p>
                        <?php
                            }
                        ?>
                    </div>
                    <hr class="detail__divider">
                    <div class="detail__actions">
                        <a href="addcart.php?id=<?php echo $row['id']; ?>">
                            <button class="detail__button">Đặt mua</button>
                        </a>
                    </div>
                    <div class="detail__policies">
                        <p><i class="fa fa-check-circle"></i> GIAO HÀNG TOÀN QUỐC</p>
                        <p><i class="fa fa-check-circle"></i> THANH TOÁN KHI NHẬN HÀNG</p>
                        <p><i class="fa fa-check-circle"></i> ĐỔI HÀNG TRONG 15 NGÀY</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>
</body>
</html>