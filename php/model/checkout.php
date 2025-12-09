<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('connect.php');

// Chuyển hướng nếu chưa đăng nhập hoặc giỏ hàng trống
if (!isset($_SESSION['username']) || empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit();
}

// Lấy thông tin người dùng từ CSDL
$user_id = $_SESSION['id-user'];
$sql_user = "SELECT * FROM users WHERE id = $user_id";
$result_user = mysqli_query($conn, $sql_user);
$user_info = mysqli_fetch_assoc($result_user);

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Thanh toán - FASHION SHOP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../images/icon-logo.gif">
    <link rel="stylesheet" type="text/css" href="../../css/model.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="../../js/model.js"></script>
</head>

<body>
    <?php include("header.php"); ?>

    <main class="main-content">
        <div class="container">
            <form action="_checkout.php" method="POST" class="checkout-form">
                <h1 class="checkout-form__title">Thông Tin Thanh Toán</h1>
                <div class="checkout-form__grid">
                    <!-- Cột thông tin khách hàng -->
                    <div class="checkout-form__customer-info">
                        <h2 class="checkout-form__section-title">Thông tin giao hàng</h2>
                        <div class="checkout-form__group">
                            <label for="fullname" class="checkout-form__label">Họ và tên</label>
                            <input type="text" id="fullname" name="fullname" class="checkout-form__input" value="<?php echo htmlspecialchars($user_info['fullname']); ?>" required>
                        </div>
                        <div class="checkout-form__group">
                            <label for="email" class="checkout-form__label">Email</label>
                            <input type="email" id="email" name="email" class="checkout-form__input" value="<?php echo htmlspecialchars($user_info['email']); ?>" required>
                        </div>
                        <div class="checkout-form__group">
                            <label for="phone" class="checkout-form__label">Số điện thoại</label>
                            <input type="text" id="phone" name="phone" class="checkout-form__input" value="<?php echo htmlspecialchars($user_info['phone']); ?>" required>
                        </div>
                        <div class="checkout-form__group">
                            <label for="address" class="checkout-form__label">Địa chỉ giao hàng</label>
                            <input type="text" id="address" name="address" class="checkout-form__input" value="<?php echo htmlspecialchars($user_info['address']); ?>" required>
                        </div>
                        <div class="checkout-form__group">
                            <label for="note" class="checkout-form__label">Ghi chú (tùy chọn)</label>
                            <textarea id="note" name="note" class="checkout-form__textarea"></textarea>
                        </div>
                    </div>

                    <!-- Cột tóm tắt đơn hàng -->
                    <div class="checkout-form__order-summary">
                        <h2 class="checkout-form__section-title">Đơn hàng của bạn</h2>
                        <table class="checkout-form__order-table">
                            <tbody>
                                <?php
                                $total_price = 0;
                                foreach ($_SESSION['cart'] as $id => $product) :
                                    $subtotal = $product['price'] * $product['quantity'];
                                    $total_price += $subtotal;
                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $product['name']; ?>
                                            <span class="checkout-form__quantity">× <?php echo $product['quantity']; ?></span>
                                        </td>
                                        <td class="checkout-form__subtotal"><?php echo number_format($subtotal); ?> đ</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="checkout-form__total-row">
                                    <th>Tổng cộng</th>
                                    <td class="checkout-form__total-price"><?php echo number_format($total_price); ?> đ</td>
                                </tr>
                                <?php
                                // Nếu có mã giảm giá được áp dụng, hiển thị chi tiết
                                if (isset($_SESSION['promotion']['discount_amount'])) :
                                    $discount_amount = $_SESSION['promotion']['discount_amount'];
                                    $new_total = $total_price - $discount_amount;
                                ?>
                                    <tr class="checkout-form__discount-row">
                                        <th>Giảm giá (<?php echo htmlspecialchars($_SESSION['promotion']['code']); ?>)</th>
                                        <td class="checkout-form__discount-amount">-<?php echo number_format($discount_amount); ?> đ</td>
                                    </tr>
                                    <tr class="checkout-form__total-row checkout-form__new-total">
                                        <th>Thành tiền</th>
                                        <td class="checkout-form__total-price"><?php echo number_format($new_total); ?> đ</td>
                                    </tr>
                                <?php endif; ?>
                            </tfoot>
                        </table>
                        <input type="text" name="promo_code" placeholder="Nhập mã giảm giá" class="checkout-form__promo-input">
                        <button type="submit" formaction="_promotion.php" formmethod="POST" class="checkout-form__promo-button">Áp dụng</button>
                        <?php if (isset($_SESSION['promo_error'])) : ?>
                            <p class="checkout-form__promo-error"><?php echo $_SESSION['promo_error']; ?></p>
                            <?php unset($_SESSION['promo_error']); ?>
                        <?php endif; ?>
                        <div class="checkout-form__payment-methods">
                            <p><strong>Phương thức thanh toán:</strong></p>
                            <label>
                                <input type="radio" name="payment_method" value="cod" checked>
                                Thanh toán khi nhận hàng (COD)
                            </label>
                        </div>
                        <button type="submit" class="checkout-form__submit-button">Đặt Hàng</button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <?php include("footer.php"); ?>
</body>

</html>