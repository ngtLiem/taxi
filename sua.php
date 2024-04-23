<?php
// Kết nối đến CSDL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "taxi";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Nhận dữ liệu từ biểu mẫu
$username = $_POST['username'];
$full_name = $_POST['full_name'];
$phone = $_POST['phone'];
$email = $_POST['email'];

// Cập nhật thông tin người dùng trong CSDL
$sql = "UPDATE khachhang SET KH_TEN='$full_name',KH_SDT='$phone', KH_EMAIL='$email' WHERE kH_USERNAME='$username'";

if ($conn->query($sql) === TRUE) {
    // echo "Thông tin người dùng đã được cập nhật thành công.";
    echo '<script language="javascript">
            alert("Đăng nhập thành công!");
            window.location.href = "suathongtin.php"; // Chuyển hướng sau khi đăng ký thành công
            </script>';
} else {
    echo "Lỗi: " . $conn->error;
}

$conn->close();
