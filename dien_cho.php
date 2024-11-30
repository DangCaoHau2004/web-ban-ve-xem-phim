<?php
include("database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Kiểm tra xem có dữ liệu ghế không
    // Cần điền thêm có tồn tại id user
    if (isset($data['ds_cho'])) {
        // Cần viết lại truy xuất id trong phiên
        $id = 1;
        $_SESSION['ds_cho'] = $data['ds_cho'];
        $seats = $_SESSION['selectedSeats'];
        // nối các chỗ thành chuỗi ngăn cách nhau bởi dấu space
        $seats = implode(" ", $seats);
        $ds_cho = $_SESSION['ds_cho'];
        $id_lich_chieu = (int)$_SESSION['id_lich_chieu'];
        // đặt biến kiểm tra xem có tồn tại trong database bằng false
        $kt_ton_tai = false;
        // lấy danh sách chỗ trong database
        $sql = "SELECT id_phong, ds_cho, ngay_chieu FROM lich_chieu Where id_lich_chieu = " . $id_lich_chieu;
        $result = $conn->query($sql);
        $lich_chieu = $result->fetch_all(MYSQLI_ASSOC)[0];
        $id_phong = $lich_chieu["id_phong"];
        $ds_cho_database = explode(" ", $lich_chieu["ds_cho"]);
        $ngay_het_han = $lich_chieu["ngay_chieu"];
        // lấy danh sách các chỗ đã chọn trong phiên
        $selectedSeats = $_SESSION['selectedSeats'];
        // kiểm tra xem 1 trong các ghế đã đặt thì có ghế nào tồn tại trong db

        // kiểm tra xem các chỗ đã đặt trong bảng admin_xn
        $sql = "SELECT cho_da_chon FROM admin_xn WHERE id = " . $id . " AND id_lich_chieu = " . $id_lich_chieu;
        $result = $conn->query($sql);
        $cho_yc_xn_arr = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($selectedSeats as $seat) {
            if (in_array($seat, $ds_cho_database)) {
                $kt_ton_tai = true;
            }
        }
        if (!empty($cho_yc_xn_arr)) {
            foreach ($cho_yc_xn_arr as $cho) {
                $cho_yc = explode(" ", $cho['cho_da_chon']);

                foreach ($selectedSeats as $seat) {

                    if (in_array($seat, $cho_yc)) {
                        http_response_code(404);
                        $_SESSION['ERR'] = "Bạn đã đặt một trong các chỗ đó rồi";
                        exit();
                    }
                }
            }
        }
        // nếu không tồn tại trong db
        if (!$kt_ton_tai) {
            $sql = "INSERT INTO admin_xn(id_lich_chieu, id_phong, tinh_trang, cho_da_chon, ngay_het_han, id) 
        VALUES(" . $id_lich_chieu .  "," . $id_phong . ", 0, '" . $seats . "', '" . $ngay_het_han . "'," . $id . ")";
            if ($conn->query($sql) === TRUE) {
                http_response_code(200);
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
        $_SESSION['ERR'] = "Lỗi không tồn tại chỗ hoặc user!";
    }
} else {
    header("Location: ERR404.php");
}
