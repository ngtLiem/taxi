<?php
$activate = "contact";
// @include ('connect.php');
@include('header.php');
?>
    <!-- <head>
        <table>ĐỔI MẬT KHẨU</table>
      
    </head> -->
    <!-- <style>
       form {
    background-color: #424040;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 50px 50px;
    height: 100%;
    text-align: -webkit-right;
}
    </style> -->


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
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Trang chủ<i class="ion-ios-arrow-forward"></i></a></span> <span>Đổi mật khẩu<i class="ion-ios-arrow-forward"></i></span></p>
          
          </div>
        </div>
      </div>
    </section>


<section class="ftco-section">
    <form method="POST" class="col-md-6" action="doimk.php" >
    <h1 class="mb-3 bread">Đổi mật khẩu</h1>
    <!-- <div class="text-again: center;"> -->
                <div class="col-md-12" >
                    <label for="username">Tên đăng nhập</label>
                    <input class="form-control" type="text" name="username" value="<?php echo $_SESSION["username"]?>" required >
                  </div>
                    
                  <div class="col-md-12">
                    <label for="password">Mật khẩu cũ</label>
                    <input id="password" type="password" class="form-control" data-indicator="pwindicator"
                      name="psw2" tabindex="2" required>
                  </div>

                 
                  <div class="col-md-12">
                    <label for="password">Mật khẩu mới</label>
                    <input id="password" type="password" class="form-control" data-indicator="pwindicator"
                      name="psw" tabindex="2" required>
                
                  </div>



                  <div class="col-md-12">
                    <label for="password-confirm">Xác nhận mật khẩu mới</label>
                    <input id="password-confirm" type="password" class="form-control" name="psw1"
                      tabindex="2" required>
                  </div>


<!--                   
                  <br> -->
                  <!-- <div class="col-md-12"> -->
                    <button type="submit" class="btn btn-primary py-3 px-5" tabindex="4" name="rsmk">
                      Đổi mật khẩu
                    </button>
                  <!-- </div> -->
          
                </form>
</section>
</body>
<?php
@include('footer.php');
?>