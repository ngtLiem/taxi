<!DOCTYPE html>
<html lang="en">


<!-- chat.html  21 Nov 2019 03:50:11 GMT -->
<?php
include("connect.php");
include('head.php');
?>

<body>
    <div class="loader"></div>
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
                                    <div class="card-header"
                                        style="display: flex; flex-direction: row; justify-content: space-between;">
                                        <h4>Danh sách xe trên bản đồ</h4>
                                        <a href="danhsachxe.php"><button class="btn btn-success">Hiện chi tiết danh sách
                                                xe </button></a>
                                    </div>
                                    <?php

                                        // Truy vấn SQL để lấy dữ liệu từ cơ sở dữ liệu
                                        $query = "SELECT tx.TX_MA, tx.TX_TEN, tx.TX_BANGLAI, tx.TX_SDT, tx.TX_USERNAME, tx.TX_PASSWORD, tx.TX_GIOITINH, tx.TX_HINHANH, tt.TD_DATE, tt.TT_TOADOX, tt.TT_TOADOY, TT_TRANGTHAI
                                        FROM taixe tx
                                        JOIN trangthai tt ON tx.TX_MA = tt.TX_MA
                                        WHERE (tt.TX_MA, tt.TD_DATE) IN (
                                            SELECT TX_MA, MAX(TD_DATE)
                                            FROM trangthai
                                            GROUP BY TX_MA
                                        )";
                                        $result = mysqli_query($conn, $query);

                                        // Khởi tạo một mảng PHP để chứa dữ liệu
                                        $data = array();
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $data[] = $row;
                                        }

                                        // Chuyển đổi mảng PHP thành chuỗi JSON
                                        $jsonData = json_encode($data);
                                         ?>
                                        <script>
                                            var jsonData = <?php echo json_encode($data); ?>;
                                        </script>

                                    <div class="card-body" >
                                            <div id="mapds"
                                            style="width: 100%; height: 80vh"
                                                class="mapds leaflet-container leaflet-touch leaflet-fade-anim leaflet-grab leaflet-touch-drag leaflet-touch-zoom"
                                                tabindex="0">
                                                <div class="leaflet-pane leaflet-map-pane"
                                                    style="transform: translate3d(0px, 0px, 0px);"></div>
                                            </div>
                                            <script src="assets/js/mapdsx.js"></script>
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
                                        <input type="radio" name="value" value="1"
                                            class="selectgroup-input-radio select-layout" checked>
                                        <span class="selectgroup-button">Light</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="value" value="2"
                                            class="selectgroup-input-radio select-layout">
                                        <span class="selectgroup-button">Dark</span>
                                    </label>
                                </div>
                            </div>
                            <div class="p-15 border-bottom">
                                <h6 class="font-medium m-b-10">Sidebar Color</h6>
                                <div class="selectgroup selectgroup-pills sidebar-color">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="icon-input" value="1"
                                            class="selectgroup-input select-sidebar">
                                        <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                                            data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="icon-input" value="2"
                                            class="selectgroup-input select-sidebar" checked>
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