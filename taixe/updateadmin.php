<?php
                include('connect.php');
               

                  $sql1="select*from nhanvien where NV_USERNAME='".$_SESSION["username"]."'";
                  
                  $result1 = $conn->query($sql1);
                    if($result1->num_rows>0){
                        $sql=" UPDATE nhanvien SET 
                        NV_TEN='".$_POST["ten"]."', NV_SDT='".$_POST["sdt"]."', QH_MA='".$_POST["qh"]."',NV_EMAIL='".$_POST["email"]."' WHERE NV_USERNAME='".$_SESSION["username"]."'
                        ";
                        $result2 = $conn->query($sql);
                        //echo $sql."<br>";
                        
                        if( $result2){
                            echo '<script language="javascript">
                           alert("Đã cập nhật thông tin thành công, vui lòng đăng nhập lại");
                           window.location.href = "index.php"; // Chuyển hướng về trang chủ
                             </script>';
                        }
                     
                       }
                     
                       else{
                        echo 
                        '<script language="javascript">
                            alert("Không Thể Cập Nhật!");
                            history.back();
                            exit();
                             </script>';
                        
                       }

                 
                    
                
                ?>