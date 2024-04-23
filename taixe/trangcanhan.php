<!DOCTYPE html>
<html lang="en">
<?php
  include("connect.php");
  include('head.php');
?>

<body>
  <!-- <div class="loader"></div> -->
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
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-4">
                <div class="card author-box">
                  <div class="card-body">
                    <div class="author-box-center">
                      <img alt="image" src="assets/img/users/sontung.jpg" class="rounded-circle author-box-picture">
                      <div class="clearfix"></div>
                      <div class="author-box-name">
                        <a href="#"><?php echo $_SESSION["ten"]?></a>
                      </div>
                      <div class="author-box-job">Ca sĩ</div>
                    </div>
                    <div class="text-center">
                      <div class="author-box-description">
                        <p>
                          <br>Cầm tay anh dựa vai anh
                          <br>Kề bên anh nơi này có anh
                          <br>Gió mang câu tình ca 
                          <br>Ngàn ánh sao vụt qua nhẹ ôm lấy em
                          <br>(Yêu em thương em con tim anh chân thành)
                        </p>
                      </div>
                      <div class="mb-2 mt-3">
                        <div class="text-small font-weight-bold">Follow <?php echo $_SESSION["ten"]?> </div>
                      </div>
                      <a href="#" class="btn btn-social-icon mr-1 btn-facebook">
                        <i class="fab fa-facebook-f"></i>
                      </a>
                      <a href="#" class="btn btn-social-icon mr-1 btn-twitter">
                        <i class="fab fa-twitter"></i>
                      </a>
                      <a href="#" class="btn btn-social-icon mr-1 btn-github">
                        <i class="fab fa-github"></i>
                      </a>
                      <a href="#" class="btn btn-social-icon mr-1 btn-instagram">
                        <i class="fab fa-instagram"></i>
                      </a>
                      <div class="w-100 d-sm-none"></div>
                    </div>
                  </div>
                </div>
                
              </div>
              <div class="col-12 col-md-12 col-lg-8">
                <div class="card">
                  <div class="padding-20">
                    <ul class="nav nav-tabs" id="myTab2" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"
                          aria-selected="true">Chi tiết thông tin cá nhân</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings" role="tab"
                          aria-selected="false">Chỉnh sửa thông tin</a>
                      </li>
                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content">
                      <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
                        <div class="row">
                          <div class="col-md-3 col-6 b-r">
                            <strong>Tên đầy đủ</strong>
                            <br>
                            <p class="text-muted"><?php echo $_SESSION["ten"]?></p>
                          </div>
                          <div class="col-md-3 col-6 b-r">
                            <strong>Số điện thoại</strong>
                            <br>
                            <p class="text-muted"><?php echo $_SESSION["sdt"]?></p>
                          </div>
                          <div class="col-md-3 col-6 b-r">
                            <strong>Bằng lái</strong>
                            <br>
                            <p class="text-muted"><?php echo $_SESSION["banglai"]?></p>
                          </div>
                          <div class="col-md-3 col-6">
                            <strong>Tên đăng nhập</strong>
                            <br>
                            <p class="text-muted"><?php echo $_SESSION["username"]?></p>
                          </div>
                          <div class="col-md-3 col-6">
                            <strong>Giới tính</strong>
                            <br>
                            <p class="text-muted">
                              <?php
                                $gioiTinh = $_SESSION["gioitinh"];
                                if ($gioiTinh == 1) {
                                    echo "Nam";
                                } elseif ($gioiTinh == 0) {
                                    echo "Nữ";
                                } else {
                                    echo "Không xác định";
                                }
                            ?>
                            </p>
                          </div>
                          
                        </div>
                      </div>
                      <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab2">
                        <form method="post" class="needs-validation" action="updatetaixe.php">
                          <div class="card-header">
                            <h4>Chỉnh sửa thông tin cá nhân</h4>
                          </div>
                          <div class="card-body">
                            <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>Tên đăng nhập</label>
                                <input  type="text" disabled class="form-control" value="<?php echo $_SESSION["username"]?>">
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Vai trò</label>
                                <input  type="text" disabled class="form-control" value="<?php 
                                    $sql = "SELECT VT_TEN from vaitro where VT_MA = {$_SESSION["vaitro"]}";
                                    $rs = $conn->query($sql);
                                    $vt = $rs->fetch_assoc();
                                    echo $vt['VT_TEN'];
                                  ?>">
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Bằng lái</label>
                                <input type="text" disabled class="form-control" value="<?php echo $_SESSION["banglai"]?>">
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Giới tính</label>
                                <input type="text" disabled class="form-control" value="<?php 
                                    if ($_SESSION["gioitinh"] == 1) {
                                      echo "Nam";
                                  } elseif ($_SESSION["gioitinh"] == 0) {
                                      echo "Nữ";
                                  } else {
                                      echo "Không xác định";
                                  }?>">
                              </div>
                            </div>
                            <div class="row">
                              <div class="form-group col-md-6 col-12">
                                <label>Họ và tên</label>
                                <input type="text" class="form-control" value="<?php echo $_SESSION["ten"]?>" name="TX_TEN">
                                <div class="invalid-feedback">
                                  Vui lòng nhập họ và tên
                                </div>
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Số điện thoại</label>
                                <input type="tel" class="form-control" value="<?php echo $_SESSION["sdt"]?>" name="TX_SDT">
                              </div>
                            </div>
                              
                            
                          </div>
                          <div class="card-footer text-right">
                            <button class="btn btn-primary" name="chinhsuataixe">Lưu thay đổi</button>
                          </div>
                        </form>
                      </div>
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
  <script src="assets/bundles/summernote/summernote-bs4.js"></script>
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js/custom.js"></script>
</body>


<!-- profile.html  21 Nov 2019 03:49:32 GMT -->
</html>