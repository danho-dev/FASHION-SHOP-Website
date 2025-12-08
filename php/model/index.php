<?php
require_once('connect.php');
$prd = 0;
if (isset($_SESSION['cart'])) {
    $prd = count($_SESSION['cart']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>FASHION SHOP | Website bán quần áo</title>
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
    <!-- <a href="#" class="back-to-top"><i class="fa fa-arrow-up"></i></a> -->

    <?php
    include("header.php");
    include("banner.php");
    ?>
    <!-- PRODUCT LISTTING | SẢN PHẨM MỚI -->
    <div class="container">
        <div class="index">
            <div class="index__category">
                <div class="index__header">
                    <h3 class="index__title">SẢN PHẨM MỚI</h3>
                </div>
                <div class="index__grid">
                    <?php
                    $sql = "SELECT id,image,name,price FROM products WHERE category_id=3 AND status = 0";
                    $result = mysqli_query($conn, $sql);
                    while ($kq = mysqli_fetch_assoc($result)) {
                    ?>
                        <div class="index__item">
                            <div class="index__card">
                                <div class="index__image-wrapper">
                                    <img class="index__image" src="<?php echo "../../" . $kq['image']; ?>" alt="<?php echo $kq['name']; ?>">
                                </div>
                                <div class="index__name">
                                    <?php echo $kq['name']; ?>
                                </div>
                                <div class="index__price">
                                    Giá: <?php echo number_format($kq['price']); ?> đ
                                </div>
                                <div class="index__actions">
                                    <a href="addcart.php?id=<?php echo $kq['id']; ?>">
                                        <button type="button" class="index__button">
                                            Mua hàng
                                        </button>
                                    </a>
                                    <a href="detail.php?id=<?php echo $kq['id']; ?>">
                                        <button type="button" class="index__button">Chi tiết</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!-- PRODUCT LISTTING | THỜI TRANG NAM -->
            <div class="index__category">
                <div class="index__header">
                    <h3 class="index__title">Thời Trang Nam</h3>
                </div>
                <div class="index__grid">
                    <?php
                    $sql = "SELECT id,image,name,price FROM products WHERE category_id=1 LIMIT 8";
                    $result = mysqli_query($conn, $sql);
                    while ($kq = mysqli_fetch_assoc($result)) {
                    ?>
                        <div class="index__item">
                            <div class="index__card">
                                <div class="index__image-wrapper">
                                    <img class="index__image" src="<?php echo "../../" . $kq['image']; ?>" alt="<?php echo $kq['name']; ?>">
                                </div>
                                <div class="index__name">
                                    <?php echo $kq['name']; ?>
                                </div>
                                <div class="index__price">
                                    Giá: <?php echo number_format($kq['price']); ?> đ
                                </div>
                                <div class="index__actions">
                                    <a href="addcart.php?id=<?php echo $kq['id']; ?>">
                                        <button type="button" class="index__button">
                                            Mua hàng
                                        </button>
                                    </a>
                                    <a href="detail.php?id=<?php echo $kq['id'] ?>">
                                        <button type="button" class="index__button">Chi Tiết</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!-- PRODUCT LISTTING | THỜI TRANG NỮ -->
            <div class="index__category">
                <div class="index__header">
                    <h3 class="index__title">Thời Trang Nữ</h3>
                </div>
                <div class="index__grid">
                    <?php
                    $sql = "SELECT id,image,name,price FROM products WHERE category_id=2 LIMIT 8";
                    $result = mysqli_query($conn, $sql);
                    while ($kq = mysqli_fetch_assoc($result)) {
                    ?>
                        <div class="index__item">
                            <div class="index__card">
                                <div class="index__image-wrapper">
                                    <img class="index__image" src="<?php echo "../../" . $kq['image']; ?>" alt="<?php echo $kq['name']; ?>">
                                </div>
                                <div class="index__name">
                                    <?php echo $kq['name']; ?>
                                </div>
                                <div class="index__price">
                                    Giá: <?php echo number_format($kq['price']); ?> đ
                                </div>
                                <div class="index__actions">
                                    <a href="addcart.php?id=<?php echo $kq['id']; ?>">
                                        <button type="button" class="index__button">
                                            Mua hàng
                                        </button>
                                    </a>
                                    <a href="detail.php?id=<?php echo $kq['id'] ?>">
                                        <button type="button" class="index__button">Chi Tiết</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>

<?php 
include "partner.php";
include "footer.php";
?>