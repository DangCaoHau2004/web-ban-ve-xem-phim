<?php
include("database.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Kiểm tra xem có dữ liệu ghế không
    if (isset($data['ds_cho'])) {
        $_SESSION['ds_cho'] = $data['ds_cho'];
        $seats = $_SESSION['selectedSeats'];
        // nối các chỗ thành chuỗi ngăn cách nhau bởi dấu space
        $seats = implode(" ", $seats);
        $ds_cho = $_SESSION['ds_cho'];
        $id_lich_chieu = (int)$_SESSION['id_lich_chieu'];
        // đặt biến kiểm tra xem có tồn tại trong database bằng false
        $kt_ton_tai = false;
        // lấy danh sách chỗ trong database
        $sql = "SELECT id_phong, ds_cho FROM lich_chieu Where id_lich_chieu = " . $_SESSION['id_lich_chieu'];
        $result = $conn->query($sql);
        $lich_chieu = $result->fetch_all(MYSQLI_ASSOC)[0];
        $id_phong = $lich_chieu["id_phong"];
        $ds_cho_database = explode(" ", $lich_chieu["ds_cho"]);
        // lấy danh sách các chỗ đã chọn trong phiên
        $selectedSeats = $_SESSION['selectedSeats'];
        // kiểm tra xem 1 trong các ghế đã đặt thì có ghế nào tồn tại trong db
        foreach ($selectedSeats as $seat) {
            if (in_array($seat, $ds_cho_database)) {
                $kt_ton_tai = true;
            }
        }
        // nếu không tồn tại trong db
        if (!$kt_ton_tai) {
            $sql = "INSERT INTO admin_xn(id_lich_chieu, id_phong, tinh_trang, cho_da_chon) 
        VALUES(" . $id_lich_chieu .  "," . $id_phong . ", 0, '" . $seats . "')";
            if ($conn->query($sql) === TRUE) {
                http_response_code(200);
                echo "Cập nhật thành công!";
                unset($_SESSION['ds_cho']);
                unset($_SESSION['id_lich_chieu']);
                unset($_SESSION['selectedSeats']);
            } else {
                http_response_code(404);
                echo "Lỗi cập nhật: " . $conn->error;
                $_SESSION['ERR'] = "Lỗi cập nhật: " . $conn->error;
            }
        } else {
            http_response_code(404);
            echo "Ghế đã được đặt, Vui lòng đặt lại ghế khác!!!";
            $_SESSION['ERR'] = "Ghế đã được đặt, Vui lòng đặt lại ghế khác!!!";
            unset($_SESSION['ds_cho']);
            unset($_SESSION['id_lich_chieu']);
            unset($_SESSION['selectedSeats']);
        }
    } else {
        http_response_code(404);
        echo "Không có ghế nào được chọn.";
        $_SESSION['ERR'] = "Không có ghế nào được chọn.";
    }
} else {
    header("Location: ERR404.php");
}
