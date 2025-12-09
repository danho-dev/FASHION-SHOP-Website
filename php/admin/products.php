<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('header.php');
require_once('../model/connect.php');

// Xử lý thông báo flash message từ các hành động (Thêm, Sửa, Xóa)
$message = '';
$message_type = ''; // 'success' hoặc 'error'

if (isset($_SESSION['flash_message'])) {
    $message = $_SESSION['flash_message']['text'];
    $message_type = $_SESSION['flash_message']['type'];
    unset($_SESSION['flash_message']);
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Quản lý Sản phẩm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
</head>

<body>
    <div class="products__container">
        <h1 class="products__header">Danh sách sản phẩm</h1>

        <!-- Hiển thị thông báo (nếu có) -->
        <?php if ($message) : ?>
            <div class="products__alert products__alert--<?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <a href="_product-form.php" class="products__add-button">
            <i class="fa fa-plus"></i> Thêm sản phẩm mới
        </a>

        <table class="products__table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Hình ảnh</th>
                    <th>Giá (đ)</th>
                    <th>Giảm giá (%)</th>
                    <th class="products__table-actions">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $thumbImage = !empty($row['image']) ? "../../" . $row['image'] : "../../images/no-image.png"; // Giả sử có ảnh mặc định
                ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['category_name'] ?? 'N/A'); ?></td>
                            <td class="products__table-image-cell">
                                <img src="<?php echo $thumbImage; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="products__table-product-image">
                            </td>
                            <td><?php echo number_format($row['price']); ?></td>
                            <td><?php echo $row['saleprice']; ?></td>
                            <td class="products__table-actions">
                                <a href="_product-form.php?id=<?php echo $row['id']; ?>" class="products__table-action-link products__table-action-link--edit" title="Chỉnh sửa">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="_product-delete.php?id=<?php echo $row['id']; ?>" class="products__table-action-link products__table-action-link--delete" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='7' style='text-align:center;'>Chưa có sản phẩm nào.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>