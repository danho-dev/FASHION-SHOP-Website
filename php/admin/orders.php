<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('header.php');
require_once('../model/connect.php');
?>

<div class="orders__container">
    <h1 class="orders__header">Quản lý Đơn Hàng</h1>

    <table class="orders__table">
        <thead>
            <tr>
                <th>ID Đơn Hàng</th>
                <th>Tên Khách Hàng</th>
                <th>Tổng Tiền</th>
                <th>Ngày Đặt</th>
                <th>Trạng thái</th>
                <th class="orders__table-actions">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Sửa câu truy vấn để JOIN với bảng users và lấy đúng tên cột
            $sql = "SELECT o.id, u.fullname, o.total, o.date_order, o.status 
                    FROM orders o
                    JOIN users u ON o.user_id = u.id
                    ORDER BY o.date_order DESC";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $status_text = 'Đang chờ xử lý';
                    $status_class = 'orders__status--pending';
                    if ($row['status'] == 1) { // Giả sử 1 là hoàn thành
                        $status_text = 'Đã hoàn thành';
                        $status_class = 'orders__status--completed';
                    } elseif ($row['status'] == 2) {
                        $status_text = 'Đã hủy';
                        $status_class = 'orders__status--cancelled';
                    }
            ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                        <td><?php echo number_format($row['total']); ?> đ</td>
                        <td><?php echo date("d/m/Y H:i", strtotime($row['date_order'])); ?></td>
                        <td><span class="orders__status <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                        <td class="orders__table-actions">
                            <a href="order-detail.php?id=<?php echo $row['id']; ?>" class="orders__action-link" title="Xem chi tiết">Xem chi tiết</a>
                        </td>
                    </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='6' style='text-align:center;'>Chưa có đơn hàng nào.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>