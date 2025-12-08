<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('connect.php');

// Logic thêm sản phẩm vào giỏ hàng
if (isset($_GET['id'])) {
    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (!isset($_SESSION['username'])) {
        // Hiển thị alert và chuyển hướng bằng JavaScript
        echo "<script type='text/javascript'>";
        echo "alert('Vui lòng đăng nhập để mua hàng!');";
        echo "window.location.href = 'user/login.php';";
        echo "</script>";
        exit();
    }

    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = " . $id;
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            // Nếu chưa có, thêm mới với số lượng là 1
            $_SESSION['cart'][$id] = [
                'name' => $product['name'],
                'image' => $product['image'],
                'price' => ($product['saleprice'] > 0) ? ($product['price'] - ($product['price'] * $product['saleprice'] / 100)) : $product['price'],
                'quantity' => 1
            ];
        }
        $_SESSION['add_to_cart_message'] = 'Đã thêm vào giỏ hàng thành công!';
    }
    // Chuyển hướng về trang giỏ hàng để hiển thị
    header("Location: cart.php"); 
    exit();
}

// Logic xóa sản phẩm khỏi giỏ hàng
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['remove_id'])) {
    $remove_id = $_GET['remove_id'];
    if (isset($_SESSION['cart'][$remove_id])) {
        unset($_SESSION['cart'][$remove_id]);
    }
    header("Location: cart.php");
    exit();
}

// Nếu không có hành động nào được thực hiện, chuyển hướng về trang chủ hoặc trang giỏ hàng
if (!isset($_GET['id']) && !isset($_GET['action'])) {
    header("Location: index.php"); // Hoặc cart.php tùy theo ý muốn
    exit();
}
?>