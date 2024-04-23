<?php

$activate = "car";
include('header.php');

$diemdix = $_POST['diemdix'];
$diemdiy = $_POST['diemdiy'];
$diemdenx = $_POST['diemdenx'];
$diemdeny = $_POST['diemdeny'];
$tendiemdi = $_POST['tendiemdi'];
$tendiemden = $_POST['tendiemden'];
$kcach = $_POST['kcach'];

?>

<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_3.jpg');"
    data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
            <div class="col-md-9 ftco-animate pb-5">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Trang chủ<i
                                class="ion-ios-arrow-forward"></i></a></span> <span>Xe<i
                            class="ion-ios-arrow-forward"></i></span></p>
                <h1 class="mb-3 bread">Chọn tài xế ở gần bạn</h1>
            </div>
        </div>
    </div>
</section>

<div id="map" style="display: none;" class="map leaflet-container"></div>
<section>
    <div class="container">
        <div class="row d-flex justify-content-between align-items-center mt-5">
            <div class="form-group col-5">
                <input class="form-control" readonly type="text" name="tendiemdi" id="tendiemdi" value="<?php echo $tendiemdi ?>">
            </div>
            <img src="images/carrunning.gif" style="width: 8rem;" alt="">
            <div class="form-group col-5">
                <input class="form-control" readonly type="text" name="tendiemden" id="tendiemden" value="<?php echo $tendiemden ?>">
            </div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="text">
                <?php
                    $sql = "SELECT CTG_DONGIA as gia, CTG_MA from chi_tiet_bang_gia WHERE CTG_GIACANTREN > ".$kcach." and CTG_GIACANDUOI < ".$kcach."";
                    $rs = querySqlwithResult($conn, $sql);
                    $r = $rs->fetch_assoc();
                    $gtien = $r['gia']*$kcach;
                    $mactg = $r['CTG_MA'];
                ?>
                <h5>Quãng đường: <strong><?php echo $kcach ?>km</strong> - Giá tiền/km: <strong><?php echo number_format($r['gia']); ?>đ</strong></h5>
                <h4>Tạm tính: <strong><?php echo number_format($r['gia']*$kcach); ?>đ</strong></h4>
            </div>
        </div>
    </div>
</section>
<section class="ftco-section bg-light">
    <div class="container">
        <div class="row">
            <?php
           
            
            echo '<script>';
            echo 'var map = L.map("map").setView([' . $diemdix . ', ' . $diemdiy . '], 13);';
            echo 'var tiles = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {';
            echo 'maxZoom: 19,';
            echo 'attribution: "&copy; <a href=\"http://www.openstreetmap.org/copyright\">OpenStreetMap</a>",';
            echo '}).addTo(map);';
            echo 'var route;'; // Added route variable
            echo '</script>';


            $sql = "SELECT x.X_MA, x.X_TEN, x.X_BIENSO, tx.TX_viTriX, tx.TX_viTriY, tx.tx_ten, x.x_ten, x.x_bienso, tx.tx_ma,
                        SQRT(POW(tx.TX_viTriX - '$diemdix', 2) + POW(tx.TX_viTriY - '$diemdiy', 2)) AS khoang_cach
                        FROM xe x
                        INNER JOIN chi_tiet_xe ct on x.X_MA=ct.X_MA
                        INNER JOIN tai_xe tx ON ct.TX_MA = tx.TX_MA
                        INNER JOIN trang_thai tt on tt.TX_MA=tx.TX_MA
                        where tt.TT_TINHTRANG=0
                        ORDER BY khoang_cach ASC
                        LIMIT 6;";
            $rs = $conn->query($sql);
            if ($rs) {
                while ($x = $rs->fetch_assoc()) {
                    ?>
                    <script>
                        if (route) route.remove(); // Remove existing route before adding a new one
                        route = L.Routing.control({
                            waypoints: [
                                L.latLng(<?php echo $diemdix ?>, <?php echo $diemdiy ?>),
                                L.latLng(<?php echo $x['TX_viTriX']; ?>, <?php echo $x['TX_viTriY']; ?>),
                            ],
                            draggableWaypoints: false,
                            routeWhileDragging: false,
                            fitSelectedRoutes: false,
                            lineOptions: {
                                styles: [{
                                    color: "#19d600",
                                    opacity: 0.6,
                                    weight: 6
                                }],
                            },
                            createMarker: function () {
                                return null;
                            },
                        }).addTo(map);

                        route.on('routesfound', function (event) {
                            var routes = event.routes;
                            var summary = routes[0].summary;
                            console.log(routes[0])
                            var distance = (summary.totalDistance / 1000).toFixed(2);
                            document.getElementById('distance-<?php echo $x['tx_ma']; ?>').innerHTML = "Cách bạn: " + distance + " km";
                        });
                    </script>

                    <div class="col-4">
                        <div class="car-wrap rounded ftco-animate">
                            <div class="img rounded d-flex align-items-end" style="background-image: url(images/xe/xe1.jpg">
                                <img class="fit-image fit-image-tx" src="../images/taixe/default.png"style="height: 6rem; width: 6rem; margin-left: 10px; margin-bottom: -1.3rem;" alt="">
                            </div>

                            <div class="text">
                                <h2 class="mb-0">
                                    <?php echo $x['tx_ten'] ?>
                                </h2>
                                <div class="d-flex mt-2">
                                    <p>
                                        <?php echo $x['x_ten'] . "/ BS: " . $x["x_bienso"]?> 
                                    </p></br>
                                    <p class="price ml-auto"> 5 <i style="color: #f7d219;" class="fas fa-star"></i>
                                    </p>
                                </div>
                                <p id="distance-<?php echo $x['tx_ma']; ?>">Cách bạn: <span></span></p>
                            </div>

                        <?php
                            if(isset($_POST['$tendiemdi']) && isset($_POST['$tendiemden'])){
                                $tendiemdi = $_POST['tendiemdi'];
                                $tendiemden = $_POST['tendiemden'];
                            } else{
                                $tendiemdi = "Vị trí hiện tại của bạn";
                                $tendiemden = "Đang cập nhật";
                            }
                        ?>
                            <div class="d-flex justify-content-end" style="margin-top: -2rem">
                                <a href="luuchuyenxe.php?txma=<?php echo $x['tx_ma'] ?>&kc=<?php echo $kcach?>&gt=<?php echo $gtien?>&tddix=<?php echo $diemdix?>&tddiy=<?php echo $diemdiy?>&tddenx=<?php echo $diemdenx?>&tddeny=<?php echo $diemdeny?>&tendiemdi=<?php echo $tendiemdi?>&tendiemden=<?php echo $tendiemden?>&mactg=<?php echo $mactg?>" 
                                class="btn btn-primary py-2 mb-4 mr-4">Đặt ngay</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "Không có dữ liệu phù hợp.";
            }
            ?>
        </div>
    </div>
</section>

<?php
@include('footer.php');
?>