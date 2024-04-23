<?php
$activate = "index";
@include('header.php');

// @include('chon_diemdi.php');
// @include('luudiemdi.php');
// @include('chon_diemden.php');
// @include('luudiemden');
?>

<?php
if (isset($_SESSION['kh_ma'])) {
  $form_action = "chon_taixe.php";
} else {
  $form_action = "login.php?rl=1";
}
?>
<div class="hero-wrap ftco-degree-bg" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5">
  <div class="overlay"></div>
  <div class="container" id="datxe">
    <div class="row no-gutters slider-text justify-content-start align-items-center justify-content-center">
      <div class="col-lg-8 ftco-animate">
        <div class="text w-100 text-center mb-md-5 pb-md-5">
          <h1 class="mb-4">THUÊ XE NHANH VÀ DỄ DÀNG</h1>
          <p style="font-size: 18px;">Truy cập TAXI ngay hôm nay để đặt xe một cách TIỆN LỢI và NHANH CHÓNG! Chủ động
            thời gian di chuyển với tính năng "Đặt trước" và ước tính chi phí chuyến đi ngay trên Web.</p>
          <a href="https://vimeo.com/45830194" class="icon-wrap popup-vimeo d-flex align-items-center mt-4 justify-content-center">
            <div class="icon d-flex align-items-center justify-content-center">
              <span class="ion-ios-play"></span>
            </div>
            <div class="heading-title ml-5">
              <span>Easy steps for renting a car</span>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<section style="padding: 0 !important" class="ftco-section ftco-no-pt bg-light">
  <div class="container">
    <div class="row no-gutters">
      <div class="col-md-12 featured-top">
        <div class="row no-gutters">
          <div class="col-md-12 col-lg-5 d-flex align-items-center">
            <script>
              var latitude = ""
              var longitude = ""

              function getLocation() {
                if (navigator.geolocation) {
                  navigator.geolocation.getCurrentPosition(showPosition);
                } else {
                  document.getElementById("location").innerHTML = "Trình duyệt của bạn không hỗ trợ định vị.";
                }
              }

              function showMapIndex() {
                const carMakerUrl = "images/car-maker.png";
                const userMakerUrl = "images/user-maker.png";
                const userMaker = L.icon({
                  iconUrl: userMakerUrl,
                  iconSize: [40, 50],
                  iconAnchor: [20, 50],
                });
                const carMaker = L.icon({
                  iconUrl: carMakerUrl,
                  iconSize: [40, 50],
                  iconAnchor: [20, 50],
                });

                const map = L.map("map").setView([latitude, longitude], 13); //khu vực hiển thị theo vị trí hiện tại

                var marker = L.marker([latitude, longitude], { icon: userMaker }).addTo(map); //đặt vị trí hiện tại của khách hàng

                var popup = L.popup();

                var route = null;
                var popup = null;
                jsonData.forEach(function (item) {
                  const marker = L.marker([item.TX_viTriX, item.TX_viTriY], {
                    icon: carMaker,
                  }).addTo(map);

                  marker.on("click", function () {
                    if (popup) {
                      popup.remove();
                    }
                    popup = L.popup()
                      .setLatLng([item.TX_viTriX, item.TX_viTriY])
                      .setContent(
                        `<b>Tài xế:</b> ${item.tx_ten}</br>
                                          <b>Xe:</b> ${item.x_bienso}</br>
                                          <form class="mt-2 float-end" action="#datxe" method="post">
                                          <input type="hidden" name="tx_ma" value="${item.tx_ma}">
                                          <button type="submit" class="btn btn-success">Đặt ngay</button>
                                      </form>`
                      )
                      .openOn(map);

                    if (route) {
                      route.remove();
                    }
                    route = L.Routing.control({
                      waypoints: [
                        L.latLng(latitude, longitude),
                        L.latLng(item.TX_viTriX, item.TX_viTriY),
                      ],
                      draggableWaypoints: false,
                      routeWhileDragging: false,
                      fitSelectedRoutes: false,
                      lineOptions: {
                        styles: [{ color: "#19d600", opacity: 0.6, weight: 6 }],
                      },
                      createMarker: function () {
                        return null;
                      },
                    });
                    route
                      // .on("routesfound", function (e) {
                        // console.log(e.routes[0].waypoints)
                        // e.routes[0].coordinates.forEach(function(coord, idx){
                        //   setTimeout(()=>{
                        //     if ((idx+1) === e.routes[0].coordinates.length){
                        //       alert((idx+1) + " - toi ")
                        //     }
                        //     marker.setLatLng([coord.lat, coord.lng])
                        //   }, 100*idx)
                        // })
                      // })
                      .addTo(map);
                  });
                });

                const tiles = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
                  maxZoom: 19,
                  attribution:
                    '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                }).addTo(map);
              }





              function showPosition(position) {
                latitude = position.coords.latitude;
                longitude = position.coords.longitude;
                console.log(latitude, longitude)
                showMapIndex(latitude, longitude)

              }

              getLocation()
            </script>
            <form id="myForm" action="<?php echo $form_action ?>" class="request-form ftco-animate bg-primary w-100" method="post">
              <h2>Chuyến đi của bạn</h2>
              <?php
              if (isset($_POST['tx_ma'])) {
                $matx = $_POST['tx_ma'];
                echo '<input type="hidden" name="matx" value="' . $matx . '"/>';
              } else {
                $matx = "";
              }
              ?>
              <!-- CHƯA LẤY ĐƯỢC MÃ TÀI XẾ QUA XỬ LÍ ĐẶT XE -->
              <div class="form-group">
                <input name="TX_MA" type="hidden" class="form-control" value="">
              </div>
              <div class="form-group">
                <label for="" class="label">Vị trí của bạn</label><br>
                <input class="form-control" style="font-size: 14px;" type="text" name="diemdi" id="crLocation" readonly value="">
                <input type="hidden" name="diemdix" id="diemdix">
                <input type="hidden" name="diemdiy" id="diemdiy">
                <input type="hidden" name="tendiemdi" id="tendiemdi">
              </div>

              <div class="form-group">
                <?php
                if (isset($_GET['locateden'])) {
                  $location = $_GET['locateden'];
                  $latden = $_GET['latden'];
                  $lngden = $_GET['lngden'];
                  $distance = $_GET['kcach'];
                } else {
                  $location = null;
                  $latden = '';
                  $lngden = '';
                  $distance = 0;
                }
                ?>
                <label for="" class="label">Vị trí muốn đến</label>
                <div class="d-flex flex-row justify-content-center align-items-center">
                  <input type="hidden" name="diemdenx" id="diemdenx" value="<?php echo $latden ?>">
                  <input type="hidden" name="diemdeny" id="diemdeny" value="<?php echo $lngden ?>">
                  <input type="hidden" name="kcach" id="kcach" value="<?php echo $distance ?>">
                  <input type="hidden" name="tendiemden" id="tendiemden" value="<?php echo $location ?>">

                  <input name="diemden" id="diemden" value="<?php echo $location ?>" style="font-size: 14px;" type="text" readonly class="form-control" placeholder="Vui lòng chọn điểm đến" required>
                  <a href="chon_diemden.php" style="margin-left: 10px; font-size: 20px;">
                    <i style="color: white;" class="fas fa-map-marker-alt"></i>
                  </a>
                </div>
              </div>
              <div class="form-group mt-3">
                <input type="submit" name="datxe" value="Thuê xe ngay" class="btn btn-secondary py-3 px-4">
              </div>
            </form>
          </div>
          <?php

          if (!isset($_POST['tx_ma'])) {
          ?>

            <div class="col-lg-6 col-md-12 d-flex align-items-center ml-4">
              <div class="services-wrap rounded w-100">
                <h3 class="heading-section mb-4">Cách để thuê một chiếc taxi tốt</h3>
                <div class="row d-flex mb-4">
                  <div class="col-md-4 d-flex align-self-stretch ftco-animate">
                    <div class="services w-100 text-center">
                      <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-route"></span></div>
                      <div class="text w-100">
                        <h3 class="heading mb-2">Chọn địa điểm đón của bạn</h3>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 d-flex align-self-stretch ftco-animate">
                    <div class="services w-100 text-center">
                      <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-handshake"></span></div>
                      <div class="text w-100">
                        <h3 class="heading mb-2">Chọn giao dịch tốt nhất</h3>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 d-flex align-self-stretch ftco-animate">
                    <div class="services w-100 text-center">
                      <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-rent"></span></div>
                      <div class="text w-100">
                        <h3 class="heading mb-2">Đặt thuê xe bạn chọn</h3>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- <button onclick="getLocation()" class="btn btn-primary py-3 px-4">Đặt một chiếc xe hoàn hảo</button> -->
              </div>
            </div>

          <?php
          } else {
            $matx = $_POST['tx_ma'];
            $sql = "select x.*, tx.tx_ten, x.x_ten, x.x_bienso, ddg.ddg_sao, tx.*
                        from chi_tiet_xe ct
                        inner join tai_xe tx on tx.TX_MA=ct.TX_MA
                        inner join xe x on x.X_MA=ct.X_MA
                        inner join trang_thai tt on tt.TX_MA=tx.TX_MA
                        inner join diem_danh_gia ddg on ddg.TX_MA=tx.TX_MA
                        where tt.TT_TINHTRANG=0
                        LIMIT 4;";
            $rs = querySqlwithResult($conn, $sql);
            $tt = $rs->fetch_assoc();
            // if ($tt['TX_HINHANH'] == NULL)
            //   $anhtx = "default.png";
            // else
            //   $anhtx = $tt['TX_HINHANH'];
          ?>
            <div class="col-lg-6 col-md-12 d-flex align-items-center ml-4">
              <div class="services-wrap rounded-right w-100">
                <h3 class="heading-section mb-4">Thông tin tài xế đang chọn</h3>
                <div class="row d-flex mb-4">
                  <div class="col-4 d-flex flex-column justify-content-center align-items-center">
                    <div style="width: 8rem; height: 8rem">
                      <img src="images/taixe/default.png" alt="" class="fit-image">
                    </div>
                    <span class="mt-4">
                      <?php echo $tt['TX_TEN'] ?>
                    </span>
                  </div>
                  <div class="col-3 d-flex flex-column justify-content-center align-items-center">
                    <span>
                      0 <i style="color: #f7d219;" class="fas fa-star"></i>
                    </span>
                    <span>
                      Số chuyến: 23
                    </span>
                  </div>
                  <div class="col-5 d-flex flex-column justify-content-center align-items-center">
                    <div style="width: 8rem; height: 8rem">
                      <img src="images/xe/xe1.jpg" alt="" class="fit-image" style="border-radius: 100% !important;">
                    </div>
                    <span class="mt-4">
                      <?php echo $tt['x_bienso'] ?>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          <?php
          }

          ?>
        </div>
      </div>
    </div>
</section>

<section class="ftco-section ftco-no-pt bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 heading-section text-center ftco-animate mb-5">
        <span class="subheading">Những gì chúng tôi cung cấp</span>
        <h2 class="mb-2">XE GẦN BẠN</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="row">
          <div class="col-6">
            <?php
              if (isset($_GET['locateden'])){
                $location = $_GET['locateden'];
                $latden = $_GET['latden'];
                $lngden = $_GET['lngden'];
                $distance = $_GET['kcach'];
              } else {
                $location = null;
                $latden = '1';
                $lngden = '1';
                $distance = 0;
              }

            
            $sql = "select x.*, tx.tx_ten, x.x_ten, x.x_bienso, ddg.ddg_sao, tx.TX_viTriX, tx.TX_viTriY, tx.tx_ma
                      from chi_tiet_xe ct
                      inner join tai_xe tx on tx.TX_MA=ct.TX_MA
                      inner join xe x on x.X_MA=ct.X_MA
                      inner join trang_thai tt on tt.TX_MA=tx.TX_MA
                      inner join diem_danh_gia ddg on ddg.TX_MA=tx.TX_MA
                      where tt.TT_TINHTRANG=0
                      LIMIT 4;";
            $rs = $conn->query($sql);
            $data = array();
            while ($x = $rs->fetch_assoc()) {
              $data[] = $x;
              ?>
              <div class="container p-3 py-3 mt-2"
                style="border-radius: 15px; background-color:white; box-shadow: 5px 5px 5px rgba(0,0,0,0.3);">
                <div class="card-choose">
                  <div style="width: 5rem; height: 5rem;">
                    <img src="images/xe/xe1.jpg" class="fit-image" alt="">
                  </div>
                  <div class="card-choose-content">
                    <span>
                      Tài xế: <span style="color: green; font-size: 18px;">
                        <?php echo $x['tx_ten'] ?>
                      </span>
                    </span>
                    <?php echo "Loại xe: " . $x['x_ten'] . " Biến số: " . $x["x_bienso"]?>
                    <span>
                      Đánh giá: <?php echo $x['ddg_sao'] ?> <i style="color: #f7d219;" class="fas fa-star"></i>
                    </span>
                  </div>
                  <form action="#datxe" method="post">
                    <button type="submit" class="btn btn-success">Đặt ngay</button>
                  </form>
                </div>
              </div>
              <?php
            }
            $jsonData = json_encode($data);
            ?>

          </div>
          <div class="col-6">
            <div id="map"
              class="mt-4 map leaflet-container leaflet-touch leaflet-fade-anim leaflet-grab leaflet-touch-drag leaflet-touch-zoom"
              tabindex="0">
              <div class="leaflet-pane leaflet-map-pane" style="transform: translate3d(0px, 0px, 0px);"></div>
            </div>
            <div class="leaflet-control-container">
              <div class="leaflet-top leaflet-right"></div>
              <div class="leaflet-bottom leaflet-left"></div>
              <div class="leaflet-bottom leaflet-right"></div>
            </div>
          </div>

          <script>
            var jsonData = <?php echo $jsonData; ?>
          </script>
          <!-- <script src="js/map_index.js"></script> -->
        </div>
      </div>
    </div>
  </div>
</section>





<?php
@include('footer.php');
?>