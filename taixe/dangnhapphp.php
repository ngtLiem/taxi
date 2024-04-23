<?php

require 'connect.php';

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['psw']);

$sql = "select * from tai_xe where TX_USERNAME = '".strtolower($username)."' and TX_PASSWORD = '".$password."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION["TX_ma"] = $row["TX_MA"];
    $_SESSION["ten"] = $row["TX_TEN"];
    $_SESSION["sdt"] = $row["TX_SODIENTHOAI"];
    $_SESSION["username"] = $row["TX_USERNAME"];
    $_SESSION["psw"] = $row["TX_PASSWORD"];

  $message = "Đăng nhập thành công!.";
  echo "<script type='text/javascript'>alert('$message');</script>";
  header('Refresh: 0;url=index.php');

} else {
  $message = "Tài khoản hoặc mật khẩu không đúng. Vui lòng thử lại!.";
  echo "<script type='text/javascript'>alert('$message');</script>";
  header('Refresh: 0;url=index.php');
}
$conn->close();

?>
<?php
?>
