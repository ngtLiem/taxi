<!DOCTYPE html>
<html lang="en">


<!-- 0 là chờ xử lý, 1 là chấp nhận, 2 là từ chối, 3 là xong -->
<?php
  include("connect.php");
  include('head.php');
  require 'funtions.php';
?>
<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['dongycxid'])) {
        $chuyenxeID = $_POST['dongycxid'];
        $sql = "UPDATE chuyen_xe SET CX_trangThai = 2 WHERE CX_MA = '$chuyenxeID'";

        
        $matx = $_SESSION['TX_ma'];
        $sql_update = "UPDATE trang_thai SET
                        TD_THOIGIANBATDAU = sysdate(),
                        TD_THOIGIANKETTHUC = DATE_ADD(sysdate(), INTERVAL 2 MINUTE),
                        TT_TINHTRANG = 1
                        WHERE  TX_MA = '$matx'";
        

        if ($conn->query($sql) == true && $conn->query($sql_update)==true) {
          $ms = "Bạn vừa xác nhận đồng ý thực hiện chuyến đi!";
          echo "<script type='text/javascript'>alert('$ms');</script>";
        } else {
            echo "Lỗi khi cập nhật trạng thái: " . mysqli_error($conn);
        }

        $sql = "select tx.TX_viTriX, tx.TX_viTriY from tai_xe tx join chuyen_xe cx on tx.TX_MA=cx.TX_MA where tx.TX_MA = {$_SESSION['TX_ma']}";
        $rs=$conn->query($sql);
        $td = $rs->fetch_assoc();
        $tdx = $td['TX_viTriX'];
        $tdy = $td['TX_viTriY'];

        // cập nhật trạng thái tài xế
        // $sql = "INSERT INTO trang_thai (TD_THOIGIANKETTHUC, TD_THOIGIANBATDAU, TX_MA, TT_TINHTRANG)
        //          VALUES (DATE_ADD(sysdate(), INTERVAL 2 MINUTE), sysdate(), {$_SESSION['TX_ma']}, 1);";
       

    } elseif (isset($_POST['tuchoicxid'])) {
        $chuyenxeID = $_POST['tuchoicxid'];
        $sql = "UPDATE chuyen_xe SET cx_trangThai = '3' WHERE CX_MA = '$chuyenxeID'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "Đã từ chối";
        } else {
            echo "Lỗi khi cập nhật trạng thái: " . mysqli_error($conn);
        }
    } else {
        echo "Dữ liệu POST không hợp lệ.";
    }
}
?>
<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <?php 
        include('navbar.php');
        include('sidebar.php');
      ?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
            <div class="col-12">
        <div class="card">
            <div class="card-header" style="display: flex; flex-direction: row; justify-content: space-between;">
                <h4>Thông tin chuyến đi</h4>
                <a href="hiendanhsachxetrenbando.php"><button class="btn btn-success" >Hiện xe trên bản đồ</button></a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                
                  <?php
                  // Truy vấn SQL để lấy danh sách chuyến xe do kh đặt
                  $sql = "SELECT chuyen_xe.*, khach_hang.*, tai_xe.*, thoidiem.*
                          FROM chuyen_xe
                          INNER JOIN khach_hang ON chuyen_xe.KH_MA = khach_hang.KH_MA
                          INNER JOIN tai_xe ON chuyen_xe.TX_MA = tai_xe.TX_MA
                          INNER JOIN thoidiem ON thoidiem.CX_MA = chuyen_xe.CX_MA
                          WHERE chuyen_xe.CX_trangThai = '1' AND tai_xe.TX_USERNAME = '".$_SESSION["username"]."'";
                  $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<table class="table table-striped table-hover" id="tableExport" style="width:100%;">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Mã chuyến xe</th>';
                echo '<th>Tên khách hàng</th>';
                echo '<th>Thời gian</th>';
                echo '<th>Điểm đi</th>';
                echo '<th>Điểm đến</th>';
                echo '<th>Xác nhận chuyến</th>';
                echo '<th>Trạng thái chuyến xe</th>';
                echo '<th></th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                $totalXe = 0; // Khởi tạo biến tổng số xe

                while ($row = $result->fetch_assoc()) {
                  echo "<tr>
                          <td>" . $row["CX_MA"] . "</td>
                          <td>" . $row["KH_TEN"] . "</td>
                          <td>" . $row["TD_THOIGIANBATDAU"] . "</td>
                          <td>" . $row["CX_TOADOBDX"] ."--". $row["CX_TOADOBDY"] . "</td>
                          <td>" . $row["CX_TOADOKTX"] ."--". $row["CX_TOADOKTY"] . "</td>
                          <td>
                              <form action='' method='post'>
                                  <input type='hidden' name='dongycxid' value='" . $row["CX_MA"] . "'>
                                  <button class='btn btn-link' type='submit'><i class='fa-solid fa-circle-check'></i> Đồng ý</button>
                              </form>
                              <form action='' method='post'>
                                  <input type='hidden' name='tuchoicxid' value='" . $row["CX_MA"] . "'>
                                  <button class='btn btn-link' type='submit'><i class='fa-regular fa-circle-xmark'></i> Từ chối</button>
                              </form>
                          </td>
                          <td>";
                  if ($row["CX_trangThai"] == 1) {
                      echo "Chờ xử lý";
                  } elseif ($row["CX_trangThai"] == 2) {
                      echo "Đang thực hiện";
                  } elseif ($row["CX_trangThai"] == 3) {
                      echo "Đã từ chối";
                  } elseif ($row["CX_trangThai"] == 0) {
                      echo "Đã hoàn thành";
                  }
                  echo "</td>
                        </tr>";
                  $totalXe++;
              }
              
              echo '</tbody>';
              echo '</table>';
              echo "<p>Tổng số chuyến xe: $totalXe</p>";
               // Hiển thị tổng số xe
          } else {
              echo "Không có dữ liệu xe.";
          }
        
          $conn->close();
          ?>


                        

                </div>
            </div>
        </div>
    </div>
            </div>
          </div>
        </section>
        <div class="settingSidebar">
          <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
          </a>
          <div class="settingSidebar-body ps-container ps-theme-default">
            <div class=" fade show active">
              <div class="setting-panel-header">Setting Panel
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Select Layout</h6>
                <div class="selectgroup layout-color w-50">
                  <label class="selectgroup-item">
                    <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout" checked>
                    <span class="selectgroup-button">Light</span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
                    <span class="selectgroup-button">Dark</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Sidebar Color</h6>
                <div class="selectgroup selectgroup-pills sidebar-color">
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                      data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                      data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Color Theme</h6>
                <div class="theme-setting-options">
                  <ul class="choose-theme list-unstyled mb-0">
                    <li title="white" class="active">
                      <div class="white"></div>
                    </li>
                    <li title="cyan">
                      <div class="cyan"></div>
                    </li>
                    <li title="black">
                      <div class="black"></div>
                    </li>
                    <li title="purple">
                      <div class="purple"></div>
                    </li>
                    <li title="orange">
                      <div class="orange"></div>
                    </li>
                    <li title="green">
                      <div class="green"></div>
                    </li>
                    <li title="red">
                      <div class="red"></div>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                  <label class="m-b-0">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="mini_sidebar_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Mini Sidebar</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                  <label class="m-b-0">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="sticky_header_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Sticky Header</span>
                  </label>
                </div>
              </div>
              <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                  <i class="fas fa-undo"></i> Restore Default
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          <a href="templateshub.net">Templateshub</a></a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>
  <!-- General JS Scripts -->
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <script src="assets/js/page/chat.js"></script>
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js/custom.js"></script>
</body>


<!-- chat.html  21 Nov 2019 03:50:12 GMT -->
</html>