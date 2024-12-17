<?php
include('navbar.php');
if (!isset($_SESSION['user_id'])) {
    echo "User ID không tồn tại. Vui lòng thử lại.";
    exit();
}
$user_id = $_SESSION['user_id']; // Lấy user_id từ session
$sql = "SELECT * FROM admin_xn WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin vé</title>
    <style>
        .info_ve {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 25px;
            margin-right: 15px;
        }

        .info_ve_text {
            margin-right: 970px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            height: 40px;
            width: 210px;
            color: white;
            background-color: #03599d;
        }

        .info_ve_box {
            background-color: white;
            width: 80%;
            height: 30vh;
        }
    </style>
</head>

<body>
    <form action="thongTinVe.php" method="post">
        <div class="info_ve">
            <div class="info_ve_text">
                <p>THÔNG TIN VÉ ĐÃ MUA</p>
            </div>
            <div class="info_ve_box">
                <table border="2" style="width:100%">
                    <tr>
                        <th style="padding: 10px; width:30%">NGÀY ĐẶT VÉ</th>
                        <th style="padding: 10px; width:30%">MÃ VÉ</th>
                        <th>TRẠNG THÁI</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $ma_ve = $row["ma_ve"];
                        $trang_thai = '';
                        switch ($row['tinh_trang']) {
                            case 0:
                                $trang_thai = 'Chờ xác thực';
                                break;
                            case 1:
                                $trang_thai = 'Đã xác thực thành công';
                                break;
                            case 2:
                                $trang_thai = 'Xác thực thất bại';
                                break;
                        }
                        echo "<tr>";
                        echo "<td style='padding: 10px;'>{$row['ngay_dat']}</td>";
                        echo "<td style='padding: 10px;'>{$ma_ve}</td>";
                        echo "<td style='padding: 10px;'>{$trang_thai}</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </form>
</body>

</html>