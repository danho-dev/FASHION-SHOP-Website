<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('connect.php');

// Kiểm tra xem người dùng đã đăng nhập chưa để xem giỏ hàng
if (!isset($_SESSION['username'])) {
    // Hiển thị alert và chuyển hướng bằng JavaScript
    echo "<script type='text/javascript'>";
    echo "alert('Vui lòng đăng nhập để xem giỏ hàng!');";
    echo "window.location.href = 'user/login.php';";
    echo "</script>";
    exit();
}

// Check for add to cart message
if (isset($_SESSION['add_to_cart_message'])) {
    echo "<script type='text/javascript'>alert('" . $_SESSION['add_to_cart_message'] . "');</script>";
    unset($_SESSION['add_to_cart_message']); // Clear the message after displaying
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Giỏ hàng - FASHION SHOP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../../images/icon-logo.gif">
    <link rel="stylesheet" type="text/css" href="../../css/model.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="../../js/model.js"></script>
</head>

<body>
    <?php include("header.php"); ?>

    <div class="container">
        <div class="cart">
            <h1 class="cart__title">Giỏ Hàng Của Bạn</h1>
            <?php if (!empty($_SESSION['cart'])) : ?>
                <form action="update-cart.php" method="POST">
                    <table class="cart__table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stt = 1;
                            $total_price = 0;
                            foreach ($_SESSION['cart'] as $id => $product) :
                                $subtotal = $product['price'] * $product['quantity'];
                                $total_price += $subtotal;
                            ?>
                                <tr>
                                    <td><?php echo $stt++; ?></td>
                                    <td><img class="cart__product-image" src="<?php echo "../../" . $product['image']; ?>" alt="<?php echo $product['name']; ?>"></td>
                                    <td><?php echo $product['name']; ?></td>
                                    <td><?php echo number_format($product['price']); ?> đ</td>
                                    <td>
                                        <input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo $product['quantity']; ?>" min="1" class="cart__quantity-input">
                                    </td>
                                    <td><?php echo number_format($subtotal); ?> đ</td> 
                                    <td>
                                        <a href="_cart.php?action=remove&remove_id=<?php echo $id; ?>" class="cart__remove-link" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="cart__summary">
                        <div class="cart__total">
                            <strong>Tổng cộng: <?php echo number_format($total_price); ?> đ</strong>
                        </div>
                        <div class="cart__actions">
                            <a href="index.php" class="cart__button cart__button--continue">Tiếp tục mua sắm</a>
                            <button type="submit" class="cart__button cart__button--update">Cập nhật giỏ hàng</button>
                            <a href="checkout.php" class="cart__button cart__button--checkout">Thanh toán</a>
                        </div>
                    </div>
                </form>
            <?php else : ?>
                <div class="cart__empty">
                    <p>Giỏ hàng của bạn đang trống.</p>
                    <a href="index.php" class="cart__button cart__button--continue">Quay lại cửa hàng</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include("footer.php"); ?>
</body>


</html>