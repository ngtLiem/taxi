<?php
$activate = "login";
include('connect.php');
include('header.php');
if (isset($_GET['rl'])){
  echo '<script>alert("Vui lòng đăng nhập để đặt xe!")</script>';
}
?>

<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
            <div class="col-md-9 ftco-animate pb-5">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Trang chủ<i class="ion-ios-arrow-forward"></i></a></span> <span>Thông tin cá nhân<i class="ion-ios-arrow-forward"></i></span></p>
                <h1 class="mb-3 bread">Đăng Nhập/ Đăng Ký</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section contact-section">
    <div class="container">
        <div class="container-fluid pt-1">
            <div class="text-center mb-4"></div>

            <div class="row px-xl-5">
                <!-- dag ky-->
                <div class="col-lg-12 mb-5" style="margin-top: -40px;">
                    <section class="dangky">
                        <div class="row">
                            <div class="col-6">
                                <h2>Đăng nhập</h2>
                                <form class="row g-3 formdangky" action="dangnhap.php" method="POST">
                                    <div class="col-md-12">
                                        <label for="inputNumberl4" class="form-label">Tên đăng nhập<span class="error"></span></label>
                                        <input type="text" class="form-control" id="username" name="username">
                                        <label for="inputPassword4" class="form-label">Mật khẩu<span class="error">*</span></label>
                                        <input type="password" class="form-control" id="password" name="psw">
                                        <button type="submit" class="mt-2 btn btn-success" name="dangnhap">Đăng nhập </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-6" >
                                <h2>Đăng ký</h2>
                                <form class="row g-3 formdangky" action="dangky.php" method="POST">

                                    <div class="col-12">
                                        <label for="inputAddress" class="form-label">Họ và tên<span class="error"></span> </label>
                                        <input type="text" class="form-control" id="inputAddress" placeholder="Tên" name="ten">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputAddress" class="form-label">Email<span class="error">*</span> </label>
                                        <input type="email" class="form-control" id="email" placeholder="Nhập địa chỉ email của bạn" name="email">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputNumberl4" class="form-label">Tên đăng nhập<span class="error"></span></label>
                                        <input type="text" class="form-control" id="username" name="username">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputPassword4" class="form-label">Mật khẩu<span class="error">*</span></label>
                                        <input type="password" class="form-control" id="matkhau" name="psw">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputPassword4" class="form-label">Nhập lại mật khẩu<span class="error">*</span></label>
                                        <input type="password" class="form-control" id="matkhau2" name="psw1">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputNumberl4" class="form-label">Số điện thoại<span class="error"></span></label>
                                        <input type="text" class="form-control" id="sdt" name="sdt">
                                    </div>
                                   

                                    <div class="col-md-6">
                                        <label for="inputCity" class="form-label">Giới tính</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gioitinh" id="flexRadioDefault1" value="1">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Nam
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gioitinh" id="flexRadioDefault2" value="0" checked>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                Nữ
                                            </label>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputPassword4" class="form-label">Quận Huyện<span class="error">*</span></label>
                                        <select class="form-select form-control" id="qh" name="qh">
                                            <option value="" selected>Chọn quận/huyện</option>
                                            <?php
                                            
                                            // Truy vấn để lấy danh sách quận/huyện
                                            $sql = "SELECT QH_MA, QH_TEN FROM quan_huyen";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . $row["QH_MA"] . '">' . $row["QH_TEN"] . '</option>';
                                                }
                                            }

                                            // Đóng kết nối đến cơ sở dữ liệu
                                            $conn->close();
                                            ?>
                                        </select>
                                    </div> 
                                    <div class="col-md-12">      
                                        <button type="submit" class="mt-2 btn btn-success"  name="dangky">Đăng ký </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>

            </div>

        </div>

    </div>
</section>

<?php
include('footer.php');
?>
