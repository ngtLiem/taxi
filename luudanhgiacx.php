<?php
@include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"]) && isset($_GET["macx"])) {
    // Lấy dữ liệu từ form
    $macx = $_GET["macx"];
    $saodanhgia = $_POST["saoDanhGia"];
    $noidungdg = $_POST["noiDungDanhGia"];

    // Kiểm tra xem mã chuyến xe có tồn tại trong bảng chuyenxe không
    $kiemtra_cxma = "SELECT CX_MA FROM chuyen_xe WHERE CX_MA = '$macx'";
    $result_kiemtra = $conn->query($kiemtra_cxma);

    if ($result_kiemtra->num_rows > 0) {
        $row_kiemtra = $result_kiemtra->fetch_assoc();
        $cx_ma = $row_kiemtra['CX_MA'];


        $laytaixe = "SELECT TX_MA FROM chuyen_xe WHERE CX_MA = '$cx_ma'";
        $result_tx = $conn->query($laytaixe);

        if ($result_tx->num_rows > 0) {
            $row_tx = $result_tx->fetch_assoc();
            $tx_ma = $row_tx['TX_MA'];

            $sql_themdg = "insert into DANH_GIA values('" . $macx . "', '" . $saodanhgia . "', '" . $noidungdg . "')";
            
            $result_themdg = $conn->query($sql_themdg);

            if ($result_themdg) {
                $sql_tx = "select * from chuyen_xe where cx_ma = '{$macx}'";
                $result = $conn->query($sql_tx);
                $row = $result->fetch_assoc();
                // Lấy id tài xế
                $idtx = $row["TX_MA"];
                // Update điểm đánh giá
                $sql_update_ddg = "UPDATE diem_danh_gia ddg
                                    set ddg.DDG_SAO = (select AVG(dg.DG_SAO)
                                                        from danh_gia dg
                                                        join chuyen_xe cx on cx.CX_MA=dg.CX_MA
                                                        where cx.TX_MA='{$idtx}'),
                                        ddg.DDG_TONGDIEM = (select AVG(dg.DG_SAO)*20
                                                        from danh_gia dg
                                                        join chuyen_xe cx on cx.CX_MA=dg.CX_MA
                                                        where cx.TX_MA='{$idtx}')
                                    where ddg.TX_MA ='{$idtx}' ";
                // Xử lý khi truy vấn thành công
                // header('Location: danhgiataixe.php?macx=' . $cx_ma);
                header('Location: index.php');
                exit();  // Đảm bảo dừng thực thi sau khi chuyển hướng
            } else {
                // Xử lý khi truy vấn thất bại
                die('Lỗi truy vấn: ' . mysqli_error($conn));
            }
        
        }
    } else {
        echo "Mã chuyến xe không hợp lệ!";
    }
}





$conn->close();


?>