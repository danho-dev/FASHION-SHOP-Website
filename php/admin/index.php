<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('header.php');
require_once('../model/connect.php');

// --- Lấy dữ liệu thống kê ---

// 1. Tổng số sản phẩm
$sql_total_products = "SELECT COUNT(id) as total FROM products";
$result_total_products = mysqli_query($conn, $sql_total_products);
$total_products = mysqli_fetch_assoc($result_total_products)['total'] ?? 0;

// 2. Tổng số người dùng
$sql_total_users = "SELECT COUNT(id) as total FROM users";
$result_total_users = mysqli_query($conn, $sql_total_users);
$total_users = mysqli_fetch_assoc($result_total_users)['total'] ?? 0;

// 3. Tổng số đơn hàng mới (status = 0)
$sql_new_orders = "SELECT COUNT(id) as total FROM orders WHERE status = 0";
$result_new_orders = mysqli_query($conn, $sql_new_orders);
$new_orders = mysqli_fetch_assoc($result_new_orders)['total'] ?? 0;

// 4. Tổng doanh thu (từ các đơn hàng đã hoàn thành, giả sử status = 1)
$sql_total_revenue = "SELECT SUM(total) as revenue FROM orders WHERE status = 1";
$result_total_revenue = mysqli_query($conn, $sql_total_revenue);
$total_revenue = mysqli_fetch_assoc($result_total_revenue)['revenue'] ?? 0;

?>

<main class="index__container">
    <h1 class="index__header">Tổng Quan</h1>
    <div class="index__grid">
        <!-- Card 1: Tổng sản phẩm -->
        <div class="index__card">
            <div class="index__card-icon index__card-icon--products">
                <i class="fa fa-archive"></i>
            </div>
            <div class="index__card-info">
                <div class="index__card-title">Tổng Sản Phẩm</div>
                <div class="index__card-number"><?php echo $total_products; ?></div>
            </div>
        </div>

        <!-- Card 2: Tổng người dùng -->
        <div class="index__card">
            <div class="index__card-icon index__card-icon--users">
                <i class="fa fa-users"></i>
            </div>
            <div class="index__card-info">
                <div class="index__card-title">Người Dùng</div>
                <div class="index__card-number"><?php echo $total_users; ?></div>
            </div>
        </div>

        <!-- Card 3: Đơn hàng mới -->
        <div class="index__card">
            <div class="index__card-icon index__card-icon--orders">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="index__card-info">
                <div class="index__card-title">Đơn Hàng Mới</div>
                <div class="index__card-number"><?php echo $new_orders; ?></div>
            </div>
        </div>

        <!-- Card 4: Doanh thu -->
        <div class="index__card">
            <div class="index__card-icon index__card-icon--revenue">
                <i class="fa fa-money"></i>
            </div>
            <div class="index__card-info">
                <div class="index__card-title">Tổng Doanh Thu</div>
                <div class="index__card-number"><?php echo number_format($total_revenue); ?> đ</div>
            </div>
        </div>
    </div>
</main>
