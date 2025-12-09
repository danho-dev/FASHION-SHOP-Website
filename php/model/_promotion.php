<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('connect.php');

// Xóa khuyến mãi cũ và thông báo lỗi cũ trước khi xử lý
unset($_SESSION['promotion']);
unset($_SESSION['promo_error']);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['promo_code'])) {
    $promo_code = trim($_POST['promo_code']);

    if (empty($promo_code)) {
        $_SESSION['promo_error'] = "Vui lòng nhập mã giảm giá!";
        header("Location: checkout.php");
        exit();
    }

    // Sử dụng Prepared Statement để tăng cường bảo mật
    $sql = "SELECT * FROM promotions WHERE contents = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $promo_code);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $promotion = mysqli_fetch_assoc($result);
        $discount_amount = 0;

        // Trường hợp 1: Giảm giá cho toàn bộ đơn hàng (product_id là NULL hoặc 0)
        if (is_null($promotion['product_id']) || $promotion['product_id'] == 0) {
            $total_price = 0;
            foreach ($_SESSION['cart'] as $product) {
                $total_price += $product['price'] * $product['quantity'];
            }
            $discount_amount = ($total_price * $promotion['discount_percent']) / 100;
        } 
        // Trường hợp 2: Giảm giá cho một sản phẩm cụ thể
        else {
            $promo_product_id = $promotion['product_id'];
            // Kiểm tra xem sản phẩm đó có trong giỏ hàng không
            if (isset($_SESSION['cart'][$promo_product_id])) {
                $product_in_cart = $_SESSION['cart'][$promo_product_id];
                $product_price = $product_in_cart['price'] * $product_in_cart['quantity'];
                $discount_amount = ($product_price * $promotion['discount_percent']) / 100;
            } else {
                $_SESSION['promo_error'] = "Sản phẩm yêu cầu cho mã giảm giá này không có trong giỏ hàng của bạn.";
            }
        }

        // Nếu tính được số tiền giảm giá, lưu vào session
        if ($discount_amount > 0) {
            $_SESSION['promotion'] = [
                'code' => $promotion['contents'],
                'discount_percent' => $promotion['discount_percent'],
                'discount_amount' => $discount_amount
            ];
        }
    } else {
        $_SESSION['promo_error'] = "Mã giảm giá không hợp lệ hoặc đã hết hạn!";
    }
}

// Quay trở lại trang thanh toán
header("Location: checkout.php");
exit();
?>