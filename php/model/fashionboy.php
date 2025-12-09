<?php
require_once('connect.php');
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Thời Trang Nam - FASHION SHOP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../images/icon-logo.gif">
    <link rel="stylesheet" type="text/css" href="../../css/model.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <?php include("header.php"); ?>

    <main class="main-content">
        <div class="container">
            <div class="index">
                <div class="index__category">
                    <div class="index__header">
                        <h3 class="index__title">Thời Trang Nam</h3>
                    </div>
                    <div class="index__grid">
                        <?php
                        // Lấy tất cả sản phẩm thuộc danh mục Thời trang nam (category_id = 1)
                        $sql = "SELECT id, image, name, price FROM products WHERE category_id=1";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($kq = mysqli_fetch_assoc($result)) {
                        ?>
                                <div class="index__item">
                                    <div class="index__card">
                                        <div class="index__image-wrapper">
                                            <img class="index__image" src="<?php echo "../../" . $kq['image']; ?>" alt="<?php echo htmlspecialchars($kq['name']); ?>">
                                        </div>
                                        <div class="index__name"><?php echo htmlspecialchars($kq['name']); ?></div>
                                        <div class="index__price">Giá: <?php echo number_format($kq['price']); ?> đ</div>
                                        <div class="index__actions">
                                            <a href="_cart.php?id=<?php echo $kq['id']; ?>"><button type="button" class="index__button">Mua hàng</button></a>
                                            <a href="detail.php?id=<?php echo $kq['id']; ?>"><button type="button" class="index__button">Chi tiết</button></a>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo "<p style='text-align:center; width: 100%;'>Chưa có sản phẩm nào trong danh mục này.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include("footer.php"); ?>
</body>
</html>