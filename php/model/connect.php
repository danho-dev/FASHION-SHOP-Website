<?php
$conn = mysqli_connect("localhost", "root", "", "fashion_mylishop");
mysqli_set_charset($conn, 'UTF8');

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
// echo "<script>console.log('Kết nối thành công!');</script>";
