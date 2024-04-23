<?php
require 'connect.php';
session_start();
@include('config/config.php');
@include('lib/session.php');
@include_once('lib/database.php');
@include_once('helpers/format.php');
require "funtions.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>TAXI TAXI</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">


    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php"><img src="images/logotaxi.png" style="height: 100px;"
                    alt=""><span></span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item <?php echo ($activate == "index" ? "active" : "") ?>"><a href="index.php"
                            class="nav-link">Trang chủ</a></li>
                    <li class="nav-item <?php echo ($activate == "about" ? "active" : "") ?>"><a href="about.php"
                            class="nav-link">Về chúng tôi</a></li>
                    <li class="nav-item <?php echo ($activate == "services" ? "active" : "") ?>"><a href="services.php"
                            class="nav-link">Dịch vụ</a></li>
                    <li class="nav-item <?php echo ($activate == "blog" ? "active" : "") ?>"><a href="blog.php"
                            class="nav-link">Tin tức</a></li>
                    <li class="nav-item <?php echo ($activate == "contact" ? "active" : "") ?>"><a href="contact.php"
                            class="nav-link">Liên hệ</a></li>
                </ul>
            </div>

            <ul class="navbar-nav ml-auto">
                <?php
        if (isset($_SESSION['ten'])) {
        ?>
                <li class="nav-item">
                    <a href="suathongtin.php" class="nav-link">Hi, <?php echo $_SESSION['ten'] ?></a>
                    <ul class="dropdown-menu">
                        <li><a href="suathongtin.php" class="dropdown-item">Thông tin cá nhân</a></li>
                        <li><a href="danhsachchuyenxe.php" class="dropdown-item">Danh sách chuyến xe</a></li>
                        <li><a href="doimatkhau.php" class="dropdown-item">Đổi mật khẩu</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a href="dangxuat.php" class="dropdown-item">Đăng xuất</a></li>
                    </ul>
                </li>
                <?php
        } else {
          echo '<li class="nav-item user-dropdown"><a href="login.php" class="nav-link">Đăng nhập/ Đăng ký</a></li>';
        }
        ?>
            </ul>
        </div>
    </nav>

    <style>
    /* Điều chỉnh kiểu hiển thị của dropdown */
    .menu {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .nav-item {
        position: relative;
        /* Để làm cho dropdown-menu hiển thị tương đối */
    }

    .dropdown-menu {
        display: none;
        /* Ẩn dropdown ban đầu */
        position: absolute;
        /* Hiển thị tuyệt đối trong khoảng cách của nav-item */
        top: 100%;
        /* Hiển thị bên dưới nav-item */
        left: 0;
        background-color: white;
        border: 1px solid #ddd;
        padding: 10px;
        min-width: 200px;
    }

    /* Hiển thị dropdown khi nav-link được hover hoặc click */
    .nav-item:hover .dropdown-menu {
        display: block;
    }
    </style>

    <script>
    // Lấy phần tử li có class là "nav-link"
    var navLink = document.querySelector('.nav-link');

    // Lấy phần tử ul có class là "dropdown-menu"
    var dropdownMenu = document.querySelector('.dropdown-menu');

    // Thêm sự kiện click vào phần tử li
    navLink.addEventListener('click', function() {
        // Kiểm tra xem dropdownMenu đã ẩn hay chưa
        if (dropdownMenu.style.display === 'none' || dropdownMenu.style.display === '') {
            // Nếu chưa ẩn, thì hiển thị dropdownMenu
            dropdownMenu.style.display = 'block';
        } else {
            // Nếu đã hiển thị, thì ẩn dropdownMenu
            dropdownMenu.style.display = 'none';
        }
    });
    </script>
    <!-- END nav -->