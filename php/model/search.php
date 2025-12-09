<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('connect.php');

// Khởi tạo các biến
$searchKeyword = '';
$resultSearch = null;
$totalnumber = 0;
$message = '';

// Xử lý tìm kiếm
if (isset($_POST['search']) && !empty(trim($_POST['search']))) {
    $searchKeyword = trim($_POST['search']);
    $searchParam = "%" . $searchKeyword . "%";

    // Sử dụng Prepared Statement để chống SQL Injection
    $sql = "SELECT id, image, name, price, saleprice FROM products WHERE name LIKE ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $searchParam);
    mysqli_stmt_execute($stmt);
    $resultSearch = mysqli_stmt_get_result($stmt);

    if ($resultSearch) {
        $totalnumber = mysqli_num_rows($resultSearch);
    }
} else {
    $message = "Vui lòng nhập từ khóa tìm kiếm.";
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Kết quả tìm kiếm cho "<?php echo htmlspecialchars($searchKeyword); ?>"</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../images/icon-logo.gif">
    <link rel="stylesheet" type="text/css" href="../../css/model.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="../../js/model.js"></script>
</head>

<body>
    <!-- Header -->
    <?php include("header.php"); ?>
    <!-- /header -->

    <main class="main-content">
        <div class="container">
            <div class="index">
                <div class="index__category">
                    <div class="index__header">
                        <h3 class="index__title">Kết Quả Tìm Kiếm</h3>
                    </div>
                    <p>Tìm thấy <?php echo $totalnumber; ?> sản phẩm cho từ khóa "<strong><?php echo htmlspecialchars($searchKeyword); ?></strong>"</p>

                    <div class="index__grid">
                        <?php
                        if ($totalnumber > 0) {
                            while ($kq = mysqli_fetch_assoc($resultSearch)) {
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
                                            <a href="_cart.php?id=<?php echo $kq['id']; ?>">
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
                            <?php
                            }
                        } else {
                            // Hiển thị thông báo nếu không tìm thấy sản phẩm hoặc chưa tìm kiếm
                            echo "<div style='text-align: center; width: 100%; padding: 50px 0;'>" . htmlspecialchars($message) . "</div>";
                            if ($totalnumber == 0 && !empty($searchKeyword)) {
                                echo "<div style='text-align: center; width: 100%;'>Không tìm thấy sản phẩm nào phù hợp.</div>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- footer -->
    <div class="container">
        <?php include("footer.php"); ?>
    </div>
    <!-- /footer -->

</body>

</html>