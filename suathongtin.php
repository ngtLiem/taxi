<?php 
include("header.php");
?>

<head>
    <title>Thay đổi thông tin người dùng</title>
    <!-- <link rel="stylesheet" href="css/style.css"> -->

</head>

<style>
.col-md-6 {
    margin-left: 500px;
    -webkit-box-flex: inherit;
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
    text-align: initial;
}
</style>

<body>

    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_3.jpg');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
                <div class="col-md-9 ftco-animate pb-5">
                    <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Trang chủ<i
                                    class="ion-ios-arrow-forward"></i></a></span> <span>Đổi thông tin <i
                                class="ion-ios-arrow-forward"></i></span></p>
                    <h1 class="mb-3 bread">Đổi thông tin </h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">

        <form action="sua.php" class="col-md-6" method="post">
            <h1 class="mb-3 bread">Thay đổi thông tin người dùng</h1>
            <div class="form-group">
                <label for="username">Username:</label>
                <input class="form-control" type="text" name="username" required><br>
            </div>

            <div class="form-group">
                <label for="full_name">Họ tên:</label>
                <input class="form-control" type="text" name="full_name"><br>
            </div>

            <div class="form-group">
                <label for="phone">Số điện thoại:</label>
                <input class="form-control" type="text" name="phone"><br>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input class="form-control" type="email" name="email"><br>
            </div>

            <button type="submit" class="btn btn-primary py-3 px-5"> Cập nhật </button>
            <!-- </div> -->

        </form>



    </section>

</body>

<?php 
include("footer.php");
?>