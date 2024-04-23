<!DOCTYPE html>
<html lang="en">


<!-- chat.html  21 Nov 2019 03:50:11 GMT -->
<?php
  include("connect.php");
  include('head.php');
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
                <h4>Thông tin xe</h4>
                <a href="hiendanhsachxetrenbando.php"><button class="btn btn-success" >Hiện xe trên bản đồ</button></a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                        <tbody>
                        <?php
                  // Truy vấn SQL để lấy danh sách xe với tên loại xe
                  $matx = $_SESSION["TX_ma"];
                  $sql = "select x.X_MA, x.X_TEN, x.X_BIENSO, ct.CTX_CHONGOI, ct.CTX_THONGSO, ct.CTX_NGAYBANGIAO
                            from xe x
                            join chi_tiet_xe ct on ct.X_MA=x.X_MA
                            where ct.TX_MA = {$matx}";
                $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<table class="table table-striped table-hover" id="tableExport" style="width:100%;">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Mã xe</th>';
                echo '<th>Tên xe</th>';
                echo '<th>Biển số</th>';
                echo '<th>Chỗ ngồi</th>';
                echo '<th>Thông số</th>';
                echo '<th>Ngày bàn giao</th>';
                echo '<th></th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                $totalXe = 0; // Khởi tạo biến tổng số xe

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["X_MA"] . "</td>
                            <td>" . $row["X_TEN"] . "</td>
                            <td>" . $row["X_BIENSO"] . "</td>
                            <td>" . $row["CTX_CHONGOI"] . "</td>
                            <td>" . $row["CTX_THONGSO"] . "</td>
                            <td>" . $row["CTX_NGAYBANGIAO"] . "</td>
                            <td>";
                    ?>
                    <!-- <form action="xe_sua.php" method="get">
                      <input type="hidden" name="xid" value="<?php echo $row["x_ma"] ?>">
                      <button class="btn btn-link" href="xe_sua.php"><i class="fas fa-edit"></i></button>
                    </form> -->
                    <?php
                    echo "</td>
                          <td>";
                    ?>

                    <!-- <form action="xe_xoa.php" method="get">
                      <input type="hidden" name="xid" value="<?php echo $row["x_ma"] ?>">
                      <button class="btn btn-link"><i class="fas fa-trash-alt"></i></button>
                    </form> -->
                    <?php
                    
                    echo "</td>
                          </td>
                          </tr>";

                    $totalXe++; // Tăng tổng số xe lên 1
                }

              echo '</tbody>';
              echo '</table>';

              echo "<p>Tổng số xe: $totalXe</p>"; // Hiển thị tổng số xe
          } else {
              echo "Không có dữ liệu xe.";
          }

          $conn->close();
          ?>


                        

                        </tbody>
                    </table>
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