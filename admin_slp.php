<?php
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["rap_chieu"], $_POST["ngay_chieu"], $_POST["gio_chieu"], $_POST["id_phong"], $_POST["ds_cho"])) {

        if (isset($_POST["id_lich_chieu"])) {
            // Lấy dữ liệu từ POST
            $id_lich_chieu = $_POST["id_lich_chieu"];
            $rap_chieu = $_POST["rap_chieu"];
            $ngay_chieu = $_POST["ngay_chieu"];
            $gio_chieu = $_POST["gio_chieu"];
            $id_phong = $_POST["id_phong"];
            $ds_cho = $_POST["ds_cho"];
            $ds_cho_arr = explode(" ", $ds_cho);


            // Kiểm tra các dữ liệu
            foreach ($ds_cho_arr as $dsc) {
                if (strlen($dsc) != 2) {
                    // In thông báo vào alert
                    $_SESSION["thong_bao"] = "Các dữ liệu nhập không hợp lệ";
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                }
            }

            if ($rap_chieu != 'Nhóm 4') {
                $_SESSION["thong_bao"] = "Các dữ liệu nhập không hợp lệ";


                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } elseif ($id_phong != '1' && $id_phong != '2') {

                $_SESSION["thong_bao"] = "Các dữ liệu nhập không hợp lệ";

                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }

            // Cập nhật vào cơ sở dữ liệu
            $sql = "UPDATE lich_chieu 
                        SET rap_chieu = '" . $rap_chieu . "', 
                            ngay_chieu = '" . $ngay_chieu . "', 
                            gio_chieu = '" . $gio_chieu . "', 
                            id_phong = '" . $id_phong . "', 
                            ds_cho = '" . $ds_cho . "' 
                        WHERE id_lich_chieu = " . $id_lich_chieu;

            // Thực thi câu lệnh UPDATE
            if ($conn->query($sql)) {
                $_SESSION["thong_bao"] = "Cập nhật thành công";

                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                $_SESSION["thong_bao"] = "Cập nhật thất bại";

                header("Location: " . $_SERVER['PHP_SELF']);

                exit();
            }
        } else {
            // Xử lý trường hợp không có id_lich_chieu
        }
    } else {
        $_SESSION["thong_bao"] = "Không đủ dữ kiện";

        header("Location: " . $_SERVER['PHP_SELF']);
    }
}

// Kiểm tra quyền admin
$is_admin = 1;
if ($is_admin) {
    // Lấy dữ liệu lịch chiếu
    $sql = "SELECT * FROM lich_chieu";
    $results = $conn->query($sql);
    $results = $results->fetch_all(MYSQLI_ASSOC);

    $lich_chieu = [];
    foreach ($results as $result) {
        array_push($lich_chieu, [
            "id_lich_chieu" => $result["id_lich_chieu"],
            "id_phim" => $result["id_phim"],
            "rap_chieu" => $result["rap_chieu"],
            "ngay_chieu" => $result["ngay_chieu"],
            "gio_chieu" => $result["gio_chieu"],
            "id_phong" => $result["id_phong"],
            "ds_cho" => $result["ds_cho"]
        ]);
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sửa lịch phim</title>
        <style>
            body {
                width: 100%;
                height: auto;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }
        </style>
    </head>

    <body>
        <?php if (isset($_SESSION["thong_bao"])) { ?>
            <script>
                alert('<?php echo $_SESSION["thong_bao"]; ?>');
            </script>
            <?php unset($_SESSION["thong_bao"]);
            ?>
        <?php } ?>
        <h1>Sửa lịch chiếu</h1>
        <table border="1">
            <tr>
                <td>Id phim</td>
                <td>Rạp Chiếu</td>
                <td>Ngày Chiếu</td>
                <td>Giờ Chiếu</td>
                <td>Phòng Số</td>
                <td>DS Chỗ</td>
                <td>Sửa</td>
            </tr>
            <?php foreach ($lich_chieu as $lc) { ?>
                <form action="" method="post">
                    <tr>
                        <input type="hidden" name="id_lich_chieu" value="<?php echo $lc["id_lich_chieu"]; ?>">
                        <td><input type="text" name="id_phim" value="<?php echo $lc['id_phim']; ?>"></td>
                        <td><input type="text" name="rap_chieu" value="<?php echo $lc['rap_chieu']; ?>"></td>
                        <td><input type="date" name="ngay_chieu" value="<?php echo $lc['ngay_chieu']; ?>"></td>
                        <td><input type="time" name="gio_chieu" value="<?php echo $lc['gio_chieu']; ?>"></td>
                        <td><input type="text" name="id_phong" value="<?php echo $lc['id_phong']; ?>"></td>
                        <td><input type="text" name="ds_cho" value="<?php echo $lc['ds_cho']; ?>"></td>
                        <td><button type="submit" name="sua">Sửa</button></td>
                    </tr>
                </form>
            <?php } ?>
        </table>
    </body>

    </html>
<?php } else {
    $_SESSION["ERR"] = "Bạn không có quyền truy cập trang này!";
    header("Location: ERR404.php");
} ?>