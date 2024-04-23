<?php
@include('connect.php');

// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["guidanhgia"]) && isset($_GET["macx"])) {
// Lấy dữ liệu từ form
// $macx = mysqli_real_escape_string($conn, $_GET["macx"]);
// $matc = $_POST["maTieuChi"];
// $diemtc = $_POST["diemDanhGia"];

// Kiểm tra xem mã chuyến xe có tồn tại trong bảng chuyenxe không
// $kiemtra_cxma = "SELECT CX_MA FROM chuyenxe WHERE CX_MA = '$macx'";
// $result_kiemtra = $conn->query($kiemtra_cxma);

// if ($result_kiemtra->num_rows > 0) {
// Lấy danh sách các tiêu chí từ bảng tieuchi
// $laytieuchi = "SELECT TC_MA FROM tieuchi";
// $result_tc = $conn->query($laytieuchi);

// if ($result_tc->num_rows > 0) {
//     while ($row_tc = $result_tc->fetch_assoc()) {
//         $tc_ma = $row_tc['TC_MA'];

// Lấy ID lớn nhất từ bảng danhgia để tạo ID mới
// $sql_id = "SELECT DG_MA AS id FROM danhgiatx";
// $result_id = $conn->query($sql_id);
// $row_id = $result_id->fetch_assoc();
// $id = $row_id['id'];

// Truy vấn thêm mới đánh giá
// $sql_themdg = "INSERT INTO danhgiatx (DG_MA, TC_MA, DG_DTB, TX_MA, CX_MA ) 
//                VALUES ('$id', '$tc_ma', '$diemtc[$tc_ma]', '$matx', '$macx')";

// $result_themdg = $conn->query($sql_themdg);

// if (!$result_themdg) {
// Xử lý khi truy vấn thất bại
//         die('Lỗi truy vấn: ' . mysqli_error($conn));
//     }
// }

// Xử lý khi truy vấn thành công
//             echo "Cảm ơn bạn đã đánh giá";
//         } else {
//             echo "Lấy tiêu chí thất bại!";
//         }
//     } else {
//         echo "Mã chuyến xe không hợp lệ!";
//     }
// } else {
//     echo "Lỗi r";
// }

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["guidanhgia"]) && isset($_GET["macx"])) {
    // Lấy dữ liệu từ form
    $macx = $_GET["macx"];
    $tieuchiArray = $_POST["maTieuChi"];
    $diemArray = $_POST["diemDanhGia"];

    // Kiểm tra xem mã chuyến xe có tồn tại trong bảng chuyenxe không
    $kiemtra_cxma = "SELECT CX_MA FROM chuyenxe WHERE CX_MA = '$macx'";
    $result_kiemtra = $conn->query($kiemtra_cxma);

    if ($result_kiemtra->num_rows > 0) {
        $row_kiemtra = $result_kiemtra->fetch_assoc();
        $cx_ma = $row_kiemtra['CX_MA'];

        // Lấy mã tài xế từ bảng chuyenxe
        $laytaixe = "SELECT TX_MA FROM chuyenxe WHERE CX_MA = '$cx_ma'";
        $result_tx = $conn->query($laytaixe);

        if ($result_tx->num_rows > 0) {
            $row_tx = $result_tx->fetch_assoc();
            $tx_ma = $row_tx['TX_MA'];

            // Lặp qua từng tiêu chí và điểm đánh giá
            for ($i = 0; $i < count($tieuchiArray); $i++) {
                $tc_ma = $tieuchiArray[$i];
                $diem = $diemArray[$i];

                // Lấy ID lớn nhất từ bảng danhgia để tạo ID mới
                $sql_maxid = "SELECT MAX(DG_MA) AS maxid FROM danhgiatx";
                $result_maxid = $conn->query($sql_maxid);
                $row_maxid = $result_maxid->fetch_assoc();
                $nextid = $row_maxid['maxid'] + 1;

                // Truy vấn thêm mới đánh giá
                $sql_themdg = "INSERT INTO danhgiatx (DG_MA, TC_MA, DG_DTB, TX_MA, CX_MA) 
                                VALUES ('$nextid', '$tc_ma', '$diem', '$tx_ma', '$cx_ma')";

                $result_themdg = $conn->query($sql_themdg);

                if (!$result_themdg) {
                    // Xử lý khi truy vấn thất bại
                    die('Lỗi truy vấn: ' . mysqli_error($conn));
                }
            }

            // Xử lý khi truy vấn thành công
            header('Location: index.php');
            exit();  // Đảm bảo dừng thực thi sau khi chuyển hướng
        } else {
            echo "Không lấy được tài xế";
        }
    } else {
        echo "Mã chuyến xe không hợp lệ!";
    }
}
?>

