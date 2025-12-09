<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Bắt đầu session
}
require_once('connect.php');

// Chuyển hướng nếu không phải là phương thức POST hoặc giỏ hàng trống
if ($_SERVER['REQUEST_METHOD'] != 'POST' || empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit();
}

// Bắt đầu một transaction để đảm bảo toàn vẹn dữ liệu
mysqli_begin_transaction($conn);

try {
    // 1. Lấy thông tin từ form và session
    $user_id = $_SESSION['id-user'];
    // Lấy thông tin người nhận hàng từ form POST
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $note = $_POST['note'];

    $total_money = 0;
    foreach ($_SESSION['cart'] as $product) {
        $total_money += $product['price'] * $product['quantity'];
    }

    // Trừ đi số tiền giảm giá nếu có
    if (isset($_SESSION['promotion']['discount_amount'])) {
        $total_money -= $_SESSION['promotion']['discount_amount'];
    }

    // 2. Chèn vào bảng `orders` bằng Prepared Statement
    $sql_create_order = "INSERT INTO orders (user_id, total, date_order, status) VALUES (?, ?, NOW(), 0)";
    $stmt_order = mysqli_prepare($conn, $sql_create_order);
    mysqli_stmt_bind_param($stmt_order, "id", $user_id, $total_money);
    
    if (!mysqli_stmt_execute($stmt_order)) {
        throw new Exception("Lỗi khi tạo đơn hàng: " . mysqli_stmt_error($stmt_order));
    }    

    // 3. Lấy order_id vừa tạo
    $order_id = mysqli_insert_id($conn);

    // 4. Chuẩn bị câu lệnh chèn vào bảng `product_order`
    $sql_insert_details = "INSERT INTO product_order (order_id, product_id, quantity) VALUES (?, ?, ?)";
    $stmt_details = mysqli_prepare($conn, $sql_insert_details);

    // Lặp qua giỏ hàng và thực thi câu lệnh đã chuẩn bị
    foreach ($_SESSION['cart'] as $product_id => $product) {
        $quantity = $product['quantity'];
        mysqli_stmt_bind_param($stmt_details, "iii", $order_id, $product_id, $quantity);
        
        if (!mysqli_stmt_execute($stmt_details)) {
            throw new Exception("Lỗi khi lưu chi tiết đơn hàng: " . mysqli_stmt_error($stmt_details));
        }
    }

    // 5. Nếu mọi thứ thành công, commit transaction
    mysqli_commit($conn);

    // 6. Xóa giỏ hàng và chuyển hướng
    unset($_SESSION['cart']);
    unset($_SESSION['promotion']); // Xóa cả thông tin khuyến mãi

    // Đặt thông báo thành công và chuyển hướng về trang chủ
    $_SESSION['order_success_message'] = "Bạn đã đặt hàng thành công! Cảm ơn bạn đã mua sắm.";
    header("Location: index.php");
    exit();
} catch (Exception $e) {
    // 7. Nếu có lỗi, rollback transaction
    mysqli_rollback($conn);
    // Bạn có thể ghi log lỗi ở đây: error_log($e->getMessage());
    header("Location: checkout.php?error=1"); // Chuyển về trang checkout với thông báo lỗi
    exit();
}
?>