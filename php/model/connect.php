<?php
// Kiểm tra xem extension mysqli đã được bật chưa
if (!extension_loaded('mysqli')) {
    $ini_path = php_ini_loaded_file() ?: '(Không tìm thấy file php.ini loaded)';
    die("Lỗi cấu hình Server: Extension 'mysqli' chưa được bật.<br>Vui lòng mở file: <b>$ini_path</b><br>Tìm dòng <code>;extension=mysqli</code> và xóa dấu <code>;</code> ở đầu, sau đó khởi động lại server.");
}

$conn = mysqli_connect("localhost", "root", "", "fashion_mylishop");
mysqli_set_charset($conn, 'UTF8');

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
// echo "<script>console.log('Kết nối thành công!');</script>";
