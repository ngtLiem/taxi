<?php
$activate = "danhsachchuyenxe";
@include('header.php');

// @include('config/config.php');
// @include_once('lib/database.php');
// @include_once('helpers/format.php');
?>

<style>
  ul {
    margin-top: 50px;
    margin-bottom: 50px;
    text-align: center;
  }
</style>
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
      <div class="col-md-9 ftco-animate pb-5">
        <p class="breadcrumbs"><span class="mr-2"><a href="index.hphp">Trang chủ<i class="ion-ios-arrow-forward"></i></a></span> <span>Xe đã đặt<i class="ion-ios-arrow-forward"></i></span></p>
        <h1 class="mb-3 bread">Danh sách các chuyến xe</h1>
      </div>
    </div>
  </div>
</section>

<?php

// Lấy danh sách chuyến xe đã đặt của người dùng
$user_id = $_SESSION['kh_ma'];
$sql = "select cx.CX_MA, kh.KH_TEN, cx.CX_QUANGDUONG, td.TD_THOIGIANKETTHUC, ctg.CT_SOTIEN, (ctg.CT_SOTIEN/100) as dtl
          from khach_hang kh
          join chuyen_xe cx on cx.KH_MA=kh.KH_MA
          join thoidiem td on td.CX_MA = cx.CX_MA
          join chitietgia_chuyenxe ctg on ctg.CX_MA=cx.CX_MA
          where kh.KH_MA= {$user_id}
          ORDER BY cx.CX_MA DESC";

$result = $conn->query($sql);

// Hiển thị danh sách chuyến xe đã đặt
if ($result->num_rows > 0) {

  $sql = "select KH_DIEMTICHLUY from khach_hang where KH_MA = {$user_id}";
  $rs = $conn->query($sql);
  $dtl = $rs->fetch_assoc()['KH_DIEMTICHLUY'];



  echo "<h2>Thông tin chuyến xe đã đặt</h2>";
  echo "<h4>Điểm tích lũy của bạn: ".  $dtl . " </h4>";
  echo "<ul>";
  while ($row = $result->fetch_assoc()) {
    echo  "Mã chuyến xe: " . $row['CX_MA'] . " - Tên khách hàng: " . $row['KH_TEN'] . " - Số km " . $row['CX_QUANGDUONG'] . " - Ngày đặt: " . $row['TD_THOIGIANKETTHUC'] . " - Thành tiền: " . $row['CT_SOTIEN'] . " - Điểm tích lũy: " .$row['dtl']. "<a href="."xemdanhgiachuyenxe.php?macx={$row['CX_MA']}"."> Xem đánh giá</a>" . "<br>";
    
  }
  echo "</ul>";
} else {
  echo "Bạn chưa đặt chuyến xe nào!";
}
// Đóng kết nối
$conn->close();
?>

<?php
@include('footer.php');
?>