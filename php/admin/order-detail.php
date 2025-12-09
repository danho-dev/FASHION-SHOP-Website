<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('header.php');
require_once('../model/connect.php');

// Kiểm tra xem ID đơn hàng có hợp lệ không
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: orders.php");
    exit();
}

$order_id = (int)$_GET['id'];

// --- Lấy thông tin chính của đơn hàng và thông tin khách hàng ---
$sql_order = "SELECT o.*, u.fullname, u.email, u.phone, u.address 
              FROM orders o 
              JOIN users u ON o.user_id = u.id 
              WHERE o.id = ?";
$stmt_order = mysqli_prepare($conn, $sql_order);
mysqli_stmt_bind_param($stmt_order, "i", $order_id);
mysqli_stmt_execute($stmt_order);
$result_order = mysqli_stmt_get_result($stmt_order);
$order = mysqli_fetch_assoc($result_order);

if (!$order) {
    $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Không tìm thấy đơn hàng.'];
    header("Location: orders.php");
    exit();
}

// --- Lấy chi tiết các sản phẩm trong đơn hàng ---
$sql_details = "SELECT p.name, p.image, p.price, od.quantity 
                FROM product_order od 
                JOIN products p ON od.product_id = p.id 
                WHERE od.order_id = ?";
$stmt_details = mysqli_prepare($conn, $sql_details);
mysqli_stmt_bind_param($stmt_details, "i", $order_id);
mysqli_stmt_execute($stmt_details);
$result_details = mysqli_stmt_get_result($stmt_details);

$order_details = [];
while ($row = mysqli_fetch_assoc($result_details)) {
    $order_details[] = $row;
}
?>

<div class="detail-view__container">
    <h1 class="detail-view__header">Chi Tiết Đơn Hàng #<?php echo $order['id']; ?></h1>

    <div class="detail-view__grid">
        <!-- Cột thông tin khách hàng -->
        <div class="detail-view__card">
            <h2 class="detail-view__sub-header">Thông Tin Khách Hàng</h2>
            <div class="detail-view__info-item">
                <span class="detail-view__label">Họ và tên:</span>
                <span class="detail-view__value"><?php echo htmlspecialchars($order['fullname']); ?></span>
            </div>
            <div class="detail-view__info-item">
                <span class="detail-view__label">Email:</span>
                <span class="detail-view__value"><?php echo htmlspecialchars($order['email']); ?></span>
            </div>
            <div class="detail-view__info-item">
                <span class="detail-view__label">Số điện thoại:</span>
                <span class="detail-view__value"><?php echo htmlspecialchars($order['phone']); ?></span>
            </div>
            <div class="detail-view__info-item">
                <span class="detail-view__label">Địa chỉ giao hàng:</span>
                <span class="detail-view__value"><?php echo htmlspecialchars($order['address']); ?></span>
            </div>
        </div>

        <!-- Cột cập nhật trạng thái -->
        <div class="detail-view__card">
            <h2 class="detail-view__sub-header">Cập Nhật Trạng Thái</h2>
            <form action="_order-process.php" method="POST">
                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                <div class="detail-view__form-group">
                    <label for="status" class="detail-view__label">Trạng thái đơn hàng:</label>
                    <select name="status" id="status" class="detail-view__select">
                        <option value="0" <?php echo ($order['status'] == 0) ? 'selected' : ''; ?>>Đang chờ xử lý</option>
                        <option value="1" <?php echo ($order['status'] == 1) ? 'selected' : ''; ?>>Đã hoàn thành</option>
                        <option value="2" <?php echo ($order['status'] == 2) ? 'selected' : ''; ?>>Đã hủy</option>
                    </select>
                </div>
                <button type="submit" name="update_status" class="detail-view__button">Cập Nhật</button>
            </form>
        </div>
    </div>

    <!-- Bảng chi tiết sản phẩm -->
    <div class="detail-view__card" style="margin-top: 20px;">
        <h2 class="detail-view__sub-header">Các Sản Phẩm Đã Đặt</h2>
        <table class="orders__table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_details as $item) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><img src="<?php echo '../../' . htmlspecialchars($item['image']); ?>" alt="" class="orders__product-image"></td>
                        <td><?php echo number_format($item['price']); ?> đ</td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo number_format($item['price'] * $item['quantity']); ?> đ</td>
                    </tr>
                <?php endforeach; ?>
                <tr class="orders__total-row">
                    <td colspan="4">Tổng cộng</td>
                    <td><?php echo number_format($order['total']); ?> đ</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>