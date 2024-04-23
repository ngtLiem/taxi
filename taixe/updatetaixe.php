<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "taxi";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
session_start();

$sql = "SELECT * FROM taixe WHERE TX_USERNAME = '".$_SESSION["username"]."'";
$result = $conn->query($sql);
// Cập nhật khách hàng vào cơ sở dữ liệu
    $hoTen = $_POST['TX_TEN'];
    $sql = "UPDATE taixe SET TX_TEN = '".$_POST['TX_TEN']."', TX_SDT = '".$_POST["TX_SDT"]."' 
    WHERE TX_USERNAME = '".$_SESSION["username"]."'";

 $result = $conn->query($sql);

if ( $result) {
  echo '<script language="javascript">
  alert("Cập nhật tài xế thành công!");
  history.back();
    </script>';
} else {
    echo "Cập nhật tài xế thất bại: " . $conn->error;
}


// Đóng kết nối
$conn->close();
?>