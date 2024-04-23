<?php
$activate = "xulydatxe";
@include('header.php');
$macx = $_GET['macx'];
?>

<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_3.jpg');"
    data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
            <div class="col-md-9 ftco-animate pb-5">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.hphp">Trang chủ<i
                                class="ion-ios-arrow-forward"></i></a></span> <span>Đặt xe<i
                            class="ion-ios-arrow-forward"></i></span></p>
                <h1 class="mb-3 bread">Thông tin chuyến xe</h1>
            </div>
        </div>
    </div>
</section>


<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-7 text-center heading-section ftco-animate">
                <h2 class="mb-3">Theo dõi chuyến xe</h2>
            </div>
        </div>
        <div class="row" id="watch">
            <?php

            $sql = "SELECT * FROM chuyen_xe  WHERE CX_MA = $macx";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc()

                ?>

            <?php
            if ($row['CX_trangThai'] == 1) {
                echo '<div class="col-lg-4 col-md-4 text-center">
                        <div class="services services-2 w-100">
                            <div class="icon d-flex align-items-center justify-content-center"><span
                                    class="far fa-check-circle fa-lg"></span></div>
                            <div class="text w-100">
                                <h3 class="heading mb-2">Đang chờ xác nhận</h3>
                            </div>
                            <span>Đang đón khách</span>
                        </div>
                    </div>';
            } else {
                echo '<div class="col-lg-4 col-md-4 text-center">
                        <div class="services services-2 w-100">
                            <div class="icon d-flex align-items-center justify-content-center"><span
                                    class="far fa-check-circle fa-lg"></span></div>
                            <div class="text w-100">
                                <h3 class="heading mb-2">Đang chờ xác nhận</h3>
                            </div>
                        </div>
                    </div>';
            }
            ?>



            <div class="col-md-4 text-center arrow">
                <div class="services services-2 w-100 ">
                    <div class="icon d-flex align-items-center justify-content-center  <?php if ($row['CX_trangThai'] == 2)
                        echo 'disable' ?> ">
                            <span class="flaticon-route"></span>
                        </div>
                        <div class="text w-100">
                            <h3 class="heading mb-2">Đang thực hiện</h3>
                        </div>
                    </div>
                </div>
            <?php
                $sql = "select TD_THOIGIANKETTHUC from thoidiem where CX_MA = '$macx'";
                $rs = $conn->query($sql);
                $r = $rs->fetch_assoc();
                $tdkt = $r['TD_THOIGIANKETTHUC'];

                $layngay = "SELECT sysdate() as date FROM dual";
                $result_ngay = $conn->query($layngay);
                $sysdate = $result_ngay->fetch_assoc();
                $date = $sysdate['date'];

                if($date >= $tdkt){
                    $sql = "UPDATE chuyen_xe SET CX_trangThai = '0' WHERE CX_MA = '$macx'";
                    $result = mysqli_query($conn, $sql);
                    if($result && $date >= $tdkt){
                        
                        echo '
                        <div class="col-md-4 text-center arrow">
                            <div class="services services-2 w-100">
                                <div class="icon d-flex align-items-center justify-content-center disable>
                                    <span class="fas fa-laugh-beam"></span>
                                </div>
                                <div class="text w-100">
                                    <h3 class="heading mb-2">Đã hoàn thành</h3>
                                </div>
                            </div>
                        </div>
                        ';

                        
                        $sql_tx = "select TX_MA from chuyen_xe where CX_MA = '$macx'";
                        $rs = $conn->query($sql_tx);
                        $matx = $rs->fetch_assoc()['TX_MA'];
                        $sql_update = "UPDATE trang_thai SET
                                    TD_THOIGIANBATDAU = sysdate(),
                                    TD_THOIGIANKETTHUC = DATE_ADD(sysdate(), INTERVAL 2 MINUTE),
                                    TT_TINHTRANG = 0
                                    WHERE  TX_MA = '$matx'";
                        if($conn->query($sql_update) == true){
                            $ms = "Tài xế đã hoàn thành chuyến xe!";
                            echo "<script type='text/javascript'>alert('$ms');</script>";
                        }
                    } 
                }
            ?>    
                <!-- <div class="col-md-4 text-center arrow">
                    <div class="services services-2 w-100">
                        <div class="icon d-flex align-items-center justify-content-center  <?php if ($row['CX_trangThai'] == 0)
                        echo 'disable' ?> ">
                            <span class="fas fa-laugh-beam"></span>
                        </div>
                        <div class="text w-100">
                            <h3 class="heading mb-2">Đã hoàn thành</h3>
                        </div>
                    </div>
                </div> -->

                <?php

                    $sql = "SELECT * FROM chuyen_xe  WHERE CX_MA = $macx";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if ($row["CX_trangThai"] == 0) {
                                $makh = $_SESSION["kh_ma"];
                                $sql = "select CEILING(sum(ctg.CT_SOTIEN)/100) as dtl
                                            from khach_hang kh
                                            join chuyen_xe cx on cx.KH_MA=kh.KH_MA
                                            join chitietgia_chuyenxe ctg on ctg.CX_MA=cx.CX_MA
                                            where kh.KH_MA={$makh};";
                                $rs = $conn->query($sql);
                                $r = $rs->fetch_assoc();
                                $diemtl = $r['dtl'];

                                $sql_update_dtl = "update khach_hang set KH_DIEMTICHLUY = '".$diemtl."' where  KH_MA = {$makh}";
                                $result_update = mysqli_query($conn, $sql_update_dtl);
                                if($result_update){
                            ?>
                        <div class="container-fluid mt-4 d-flex justify-content-center align-items-center">
                            <button type="button" class="btn btn-secondary p-3" onclick="redirectPage()"
                                style="color:blueviolet;">Đánh giá chuyến xe</button>
                        </div>
                        <?php
                                }
                            }
                        }
                    } else {
                        echo '';
                    }
                    ?>
        </div>
    </div>
</section>
<script>
    function redirectPage() {
        window.location.href = "danhgiachuyenxe.php?macx=<?php echo $_GET['macx'] ?>";
    }
</script>
<style>
    .disable {
        background: #808080 !important;
    }

    .arrow {
        position: relative;
        background-color: #fff;
        border-radius: 5px;
        display: flex;
        align-items: center;
    }

    .arrow:before {
        content: '';
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 10px 0 10px 20px;
        border-color: transparent transparent transparent #8fd19e;
        margin-right: 10px;
    }

    .services {
        position: relative;
        z-index: 1;
    }
</style>




<?php
@include('footer.php');
?>