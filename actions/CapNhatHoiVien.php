<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Cấu hình Database theo đúng info của mày
    $servername = "localhost";
    $username = "dev_user";
    $password = "123"; 
    $dbname = "gym_pro"; 

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Lấy dữ liệu từ Form (Bây giờ $_POST['trang_thai'] sẽ là 'active', 'expiring',...)
    $id = $_POST['id'];
    $ho_ten = $_POST['ho_ten'];
    $sdt = $_POST['sdt'];
    $email = $_POST['email'];
    $goi_tap_id = !empty($_POST['goi_tap_id']) ? $_POST['goi_tap_id'] : NULL;
    $ngay_het_han = $_POST['ngay_het_han'];
    $trang_thai = $_POST['trang_thai'];

    // Xử lý ngày hết hạn nếu trống
    if (empty($ngay_het_han)) {
        $ngay_het_han = NULL;
    }

    // Cập nhật Database
    $sql = "UPDATE hoi_vien SET ho_ten=?, sdt=?, email=?, goi_tap_id=?, ngay_het_han=?, trang_thai=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    
    // 6 string (s), 1 integer (i)
    $stmt->bind_param("sssissi", $ho_ten, $sdt, $email, $goi_tap_id, $ngay_het_han, $trang_thai, $id);

    if ($stmt->execute()) {
        header("Location: ../Admin/HoiVien.php");
        exit();
    } else {
        echo "Lỗi khi cập nhật: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../Admin/HoiVien.php");
    exit();
}
?>