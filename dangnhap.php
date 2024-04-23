<?php

require 'connect.php';
session_start();

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['psw']);

$sql = "select * from khach_hang where kh_username = '".strtolower($username)."' and kh_password = '".$password."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $_SESSION["id"] = $row["KH_MA"];
  $_SESSION["kh_ma"] = $row["KH_MA"];
  $_SESSION["qh"] = $row["QH_MA"];
  $_SESSION["ten"] = $row["KH_TEN"];
  $_SESSION["sdt"] = $row["KH_SODIENTHOAI"];
  $_SESSION["email"] = $row["KH_EMAIL"];
  $_SESSION["username"] = $row["KH_USERNAME"];
  $_SESSION["psw"] = $row["KH_PASSWORD"];
  $_SESSION["diemtl"] = $row["KH_DIEMTICHLUY"];

  $pwss = $_SESSION["psw"];

  $message = "Đăng nhập thành công!.";
  echo "<script type='text/javascript'>alert('$message');</script>";
  header('Refresh: 0;url=index.php');

  // header('Location: index.php');
} else {
  $message = "Tài khoản hoặc mật khẩu không đúng. Vui lòng thử lại!.";
  echo "<script type='text/javascript'>alert('$message');</script>";
  header('Refresh: 10;url=index.php');
}
$conn->close();

?>
<?php
?>
