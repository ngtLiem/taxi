<?php
@include('connect.php');
if (isset($_GET['cx_ma'])) {
    $cx_ma = $_GET['cx_ma'];
    $kiemtra_cxma = "SELECT CX_MA FROM chuyenxe WHERE CX_MA = '$cx_ma'";
    $result_kiemtra = $conn->query($kiemtra_cxma);
    if ($result_kiemtra->num_rows > 0) {
        $row_kiemtra = $result_kiemtra->fetch_assoc();
        $TX_MA = $row_kiemtra['TX_MA'];
        $sql = "SELECT MAX(CX_MA) AS macxid FROM chuyenxe";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $nextid = $row['macxid'] + 1;

        $dg_ma = ""; 
        $tc_ma = ""; 
        $tx_ma = ""; 
        $dgtc_diem = ""; 
        $sql_themdg = "INSERT INTO dgtieuchi (DG_MA, TC_MA, TX_MA, DGTC_DIEM)
        VALUES ('$dg_ma', '$tc_ma', '$tx_ma', '$dgtc_diem')";
        if ($result_themdg) {
            // Xử lý khi truy vấn thành công
            header('Location: danhgiachuyenxe.php?macx=' . $nextid);
        } else {
            // Xử lý khi truy vấn thất bại
            echo "Thêm đánh giá thất bại";
        }
    } else {
        echo "Lỗi: Giá trị TX_MA không hợp lệ.";
    }
} else {
    echo "Đánh giá thất bại!";
}
?>


