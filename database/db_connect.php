<?php
$servername = "localhost";
$username = "root";
$password = ""; // Mật khẩu rỗng như bạn đề cập
$dbname = "gym_pro";

// Khởi tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    // Phải xuất dạng JSON nếu file này được gọi từ API
    die(json_encode(['success' => false, 'message' => 'Lỗi kết nối DB: ' . $conn->connect_error]));
}

// Bật chế độ Unicode
$conn->set_charset("utf8mb4");
?>