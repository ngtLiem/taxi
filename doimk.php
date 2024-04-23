<?php

include('connect.php');

if(isset($_POST["dangky"])){
    $sql=" UPDATE khach_hang SET 
                KH_PASSWORD='".$_POST["psw2"]."',
                KH_TEN='".$_POST["ten"]."',
                KH_SODIENTHOAI='".$_POST["sdt"]."', 
                KH_EMAIL='".$_POST["email"]."' 
                WHERE KH_USERNAME = '".$_SESSION["username"]."'
    ";
    $result = $conn->query($sql);
    if($result){
        echo '<script language="javascript">
        alert("Đã lưu thông tin!");
        window.location.href = "index.php"; // Chuyển hướng về trang chủ
        </script>';
    } else {
        echo '<script language="javascript">
        alert("Không thể cập nhật!");
        history.back();
        </script>';
    }
}

if(isset($_POST["rsmk"])){
    $sql1 = "select * from khach_hang
    where KH_USERNAME = '".$_SESSION["username"]."' 
    and KH_PASSWORD= '".md5($_POST["psw2"])."'";
    $result = $conn->query($sql1);
    if($result->num_rows > 0){
        if($_POST["psw"]== $_POST["psw2"]){
            echo '<script language="javascript">
            alert("Mật khẩu cũ không được giống mật khẩu mới!");
            history.back();
            </script>';
        } elseif($_POST["psw"] != $_POST["psw1"]){
            echo '<script language="javascript">
            alert("Mật khẩu nhập lại không khớp!");
            history.back();
            </script>';
        } else {
            $sql=" UPDATE khach_hang set KH_PASSWORD ='".md5($_POST["psw"])." ' 
            where KH_USERNAME = '".$_SESSION["username"]." '";
            $result1 = $conn->query($sql);
            echo '<script language="javascript">
            alert("Đổi mật khẩu thành công!");
            window.location.href = "index.php"; // Chuyển hướng về trang chủ
            </script>';
        }
    } else {
        echo '<script language="javascript">
        alert("Mật khẩu cũ không đúng!");
        history.back();
        </script>';
    }
}

?>
