<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('../model/connect.php');

// --- Bảo vệ: Chỉ admin mới có quyền truy cập ---
if (!isset($_SESSION['admin_username'])) {
    $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Bạn không có quyền truy cập.'];
    header("Location: login.php");
    exit();
}

// --- Hàm xử lý upload ảnh chuyên dụng ---
function handleImageUpload($currentImage = '')
{
    // 1. Kiểm tra xem có file mới được tải lên không và không có lỗi
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        return $currentImage; // Không có ảnh mới, giữ lại ảnh cũ (quan trọng khi cập nhật)
    }

    $target_dir = "../../uploads/products/"; // Thư mục lưu trữ ảnh
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true); // Tạo thư mục nếu chưa tồn tại
    }

    // 2. Tạo tên file duy nhất để tránh ghi đè
    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $new_filename = uniqid('product_', true) . '.' . $imageFileType;
    $target_file = $target_dir . $new_filename;

    // 3. Kiểm tra định dạng ảnh hợp lệ
    $allowed_types = ['jpg', 'png', 'jpeg', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) {
        $_SESSION['form_error'] = "Chỉ cho phép các định dạng ảnh JPG, JPEG, PNG & GIF.";
        return false;
    }

    // 4. Di chuyển file đã tải lên vào thư mục đích
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Nếu upload thành công và có ảnh cũ, xóa ảnh cũ đi
        if (!empty($currentImage) && file_exists("../../" . $currentImage)) {
            unlink("../../" . $currentImage);
        }
        return 'uploads/products/' . $new_filename; // Trả về đường dẫn tương đối để lưu vào DB
    }

    $_SESSION['form_error'] = "Đã có lỗi xảy ra khi tải ảnh lên.";
    return false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu chung từ form
    $name = $_POST['name'];
    $category_id = (int)$_POST['category_id'];
    $price = (int)$_POST['price'];
    $saleprice = (int)($_POST['saleprice'] ?? 0);
    $quantity = (int)$_POST['quantity'];
    $keyword = $_POST['keyword'] ?? '';
    $description = $_POST['description'] ?? '';

    // --- XỬ LÝ THÊM MỚI SẢN PHẨM ---
    if (isset($_POST['add_product'])) {
        $image_path = handleImageUpload();
        if ($image_path === false) {
            header("Location: _product-form.php"); // Quay lại form nếu upload lỗi
            exit();
        }

        $sql = "INSERT INTO products (name, category_id, price, saleprice, quantity, image, keyword, description, created) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "siiiisss", $name, $category_id, $price, $saleprice, $quantity, $image_path, $keyword, $description);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Đã thêm sản phẩm thành công!'];
        } else {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Thêm sản phẩm thất bại. Lỗi: ' . mysqli_error($conn)];
        }
    }

    // --- XỬ LÝ CẬP NHẬT SẢN PHẨM ---
    elseif (isset($_POST['edit_product'])) {
        $product_id = (int)$_POST['product_id'];
        $current_image = $_POST['current_image'];

        $image_path = handleImageUpload($current_image);
        if ($image_path === false) {
            header("Location: _product-form.php?id=" . $product_id); // Quay lại form nếu upload lỗi
            exit();
        }

        $sql = "UPDATE products SET name=?, category_id=?, price=?, saleprice=?, quantity=?, image=?, keyword=?, description=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "siiiisssi", $name, $category_id, $price, $saleprice, $quantity, $image_path, $keyword, $description, $product_id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Đã cập nhật sản phẩm thành công!'];
        } else {
            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Cập nhật sản phẩm thất bại. Lỗi: ' . mysqli_error($conn)];
        }
    }

    // Chuyển hướng về trang danh sách sản phẩm sau khi xử lý
    header("Location: products.php");
    exit();
} else {
    // Nếu không phải POST request, chuyển về trang chính
    header("Location: index.php");
    exit();
}
?>