<?php
@include('connect.php');
if (isset($_GET['txma'])) {
    $khid = $_SESSION['kh_ma'];
    $matx = $_GET['txma'];
    $kc = $_GET['kc'];
    $gt = $_GET['gt'];
    $tddix = $_GET['tddix'];
    $tddiy = $_GET['tddiy'];
    $tddenx = $_GET['tddenx'];
    $tddeny = $_GET['tddeny'];
    $tendiemdi = $_GET['tendiemdi'];
    $tendiemden = $_GET['tendiemden'];
    $mactg = $_GET['mactg'];

    $kiemtra_txma = "SELECT TX_MA FROM tai_xe WHERE TX_MA = '$matx'";
    $result_kiemtra = $conn->query($kiemtra_txma);
    if ($result_kiemtra->num_rows > 0) {
        $row_kiemtra = $result_kiemtra->fetch_assoc();
        $TX_MA = $row_kiemtra['TX_MA'];

        $sql = "SELECT MAX(CX_MA) AS macxid FROM chuyen_xe";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $nextid = $row['macxid'] + 1;

        $layngay = "SELECT sysdate() as date FROM dual";
        $result_ngay = $conn->query($layngay);
        $sysdate = $result_ngay->fetch_assoc();
        $date = $sysdate['date'];
        

        $sql_themngay = "INSERT INTO thoidiem(CX_MA, TD_THOIGIANBATDAU, TD_THOIGIANKETTHUC) 
        VALUES('$nextid',sysdate(), DATE_ADD(sysdate(),  INTERVAL 2 MINUTE))"; "";

        $result_themngay = $conn->query($sql_themngay);
        if ($result_themngay) {

            $sql_themcx = "INSERT INTO chuyen_xe(CX_MA, TX_MA, KH_MA, CX_TOADOBATDAU, CX_NOIDEN, CX_QUANGDUONG, CX_TOADOBDX, CX_TOADOKTY, CX_TOADOBDY, CX_TOADOKTX, CX_trangThai, PTTT_MA) 
                            VALUES ('$nextid', '$TX_MA', '$khid', '$tendiemdi', '$tendiemden', '$kc', '$tddix', '$tddeny', '$tddiy', '$tddenx', '1', '001')";
            $result = mysqli_query($conn, $sql_themcx);
            if (!$result) {
                die('Lỗi truy vấn: ' . mysqli_error($conn));
            } else {
                $sql_chitietgiacx = "INSERT INTO chitietgia_chuyenxe VALUES ('$nextid', '$mactg', '$gt')";
                $rs = mysqli_query($conn, $sql_chitietgiacx);
                if(!$rs) {
                    die('Lỗi truy vấn: ' . mysqli_error($conn));
                } else {
                    header('Location: xulydatxe.php?macx='.$nextid.'');
                }
            }
        } else {
            echo "Thêm ngày thất bại";
        }
    } else {
        echo "Lỗi: Giá trị TX_MA không hợp lệ.";
    }
} else {
    echo "Đặt xe thất bại!";
}


