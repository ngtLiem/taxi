<?php
// Include your database connection here (connect.php)

// 1. Truy vấn SQL để lấy dữ liệu từ cơ sở dữ liệu
$query = "SELECT TX_MA, TT_toadoX, TT_toadoY
    FROM trangthai
    WHERE (TX_MA, TD_date) IN (
        SELECT TX_MA, MAX(TD_date)
        FROM trangthai
        GROUP BY TX_MA
    )";
$result = mysqli_query($conn, $query);

// 2. Khởi tạo một mảng PHP để chứa dữ liệu
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// 3. Chuyển đổi mảng PHP thành chuỗi JSON
$jsonData = json_encode($data);

// 4. In chuỗi JSON ra ngoài
header('Content-Type: application/json');
echo $jsonData;
?>
