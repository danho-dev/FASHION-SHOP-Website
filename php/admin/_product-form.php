<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('header.php');
require_once('../model/connect.php');

// --- Khởi tạo các biến ---
$isEditMode = false;
$product_id = null;
$product = [
    'name' => '',
    'category_id' => '',
    'price' => '',
    'saleprice' => 0,
    'quantity' => '',
    'image' => '',
    'keyword' => '',
    'description' => ''
];
$pageTitle = 'Thêm Sản Phẩm Mới';
$buttonText = 'Thêm Sản Phẩm';
$formAction = '_product-process.php'; // Tệp xử lý logic
$imageRequired = 'required';

// --- Kiểm tra nếu là chế độ Chỉnh sửa ---
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $isEditMode = true;
    $product_id = $_GET['id'];

    // Sử dụng prepared statement để an toàn hơn
    $stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        $pageTitle = 'Chỉnh Sửa Sản Phẩm';
        $buttonText = 'Cập Nhật Sản Phẩm';
        $imageRequired = ''; // Không bắt buộc tải ảnh mới khi sửa
    } else {
        // Nếu không tìm thấy sản phẩm, có thể hiển thị lỗi hoặc chuyển hướng
        $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Sản phẩm không tồn tại.'];
        header("Location: products.php");
        exit();
    }
}

// Xử lý thông báo lỗi (nếu có)
$error_message = '';
if (isset($_SESSION['form_error'])) {
    $error_message = $_SESSION['form_error'];
    unset($_SESSION['form_error']);
}
?>

<div class="product-form__container">
    <h1 class="product-form__header"><?php echo $pageTitle; ?></h1>

    <?php if ($error_message) : ?>
        <div class="product-form__alert product-form__alert--error"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <form action="<?php echo $formAction; ?>" method="POST" enctype="multipart/form-data" class="product-form__form">
        <?php if ($isEditMode) : ?>
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <input type="hidden" name="current_image" value="<?php echo $product['image']; ?>">
        <?php endif; ?>

        <div class="product-form__group">
            <label for="name" class="product-form__label">Tên sản phẩm</label>
            <input type="text" id="name" name="name" class="product-form__input" placeholder="Nhập tên sản phẩm" value="<?php echo htmlspecialchars($product['name']); ?>" required />
        </div>

        <div class="product-form__group">
            <label for="category" class="product-form__label">Danh mục sản phẩm</label>
            <select id="category" class="product-form__input" name="category_id">
                <?php
                $sql_cat = "SELECT * FROM categories ORDER BY name ASC";
                $result_cat = mysqli_query($conn, $sql_cat);
                if ($result_cat) {
                    while ($row_cat = mysqli_fetch_assoc($result_cat)) {
                        $selected = ($row_cat['id'] == $product['category_id']) ? 'selected' : '';
                        echo "<option value='{$row_cat['id']}' {$selected}>" . htmlspecialchars($row_cat['name']) . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="product-form__grid">
            <div class="product-form__group">
                <label for="price" class="product-form__label">Giá sản phẩm (đ)</label>
                <input type="number" id="price" class="product-form__input" name="price" placeholder="VD: 250000" value="<?php echo $product['price']; ?>" min="0" required />
            </div>
            <div class="product-form__group">
                <label for="saleprice" class="product-form__label">Giảm giá (%)</label>
                <input type="number" id="saleprice" class="product-form__input" name="saleprice" placeholder="VD: 10" value="<?php echo $product['saleprice']; ?>" min="0" max="99" />
            </div>
        </div>

        <div class="product-form__group">
            <label for="quantity" class="product-form__label">Số lượng trong kho</label>
            <input type="number" id="quantity" class="product-form__input" name="quantity" placeholder="Nhập số lượng" value="<?php echo $product['quantity']; ?>" min="0" required />
        </div>

        <div class="product-form__group">
            <label class="product-form__label">Hình ảnh sản phẩm</label>
            <?php if ($isEditMode && !empty($product['image'])) : ?>
                <div class="product-form__current-image">
                    <p>Ảnh hiện tại:</p>
                    <img src="<?php echo "../../" . htmlspecialchars($product['image']); ?>" alt="Ảnh sản phẩm">
                </div>
                <p>Chọn ảnh mới để thay thế (không bắt buộc):</p>
            <?php endif; ?>
            <input type="file" name="image" class="product-form__file-input" <?php echo $imageRequired; ?>>
        </div>

        <div class="product-form__group">
            <label for="keyword" class="product-form__label">Từ khóa tìm kiếm</label>
            <input type="text" id="keyword" class="product-form__input" name="keyword" placeholder="VD: áo thun, quần jean, unisex" value="<?php echo htmlspecialchars($product['keyword']); ?>" />
        </div>

        <div class="product-form__group">
            <label for="description" class="product-form__label">Mô tả sản phẩm</label>
            <textarea id="description" class="product-form__textarea" rows="5" name="description" placeholder="Nhập mô tả chi tiết cho sản phẩm..."><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>

        <div class="product-form__actions">
            <button type="submit" name="<?php echo $isEditMode ? 'edit_product' : 'add_product'; ?>" class="product-form__button product-form__button--submit">
                <?php echo $buttonText; ?>
            </button>
            <a href="products.php" class="product-form__button product-form__button--cancel">Hủy</a>
        </div>
    </form>
</div>