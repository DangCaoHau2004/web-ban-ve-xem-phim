<?php
include("database.php");
// abc
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["rap_chieu"], $_POST["ngay_chieu"], $_POST["gio_chieu"], $_POST["id_phong"], $_POST["id_phim"])) {
        $id_phim = $_POST["id_phim"];
        $rap_chieu = $_POST["rap_chieu"];
        $ngay_chieu = $_POST["ngay_chieu"];
        $gio_chieu = $_POST["gio_chieu"];
        $id_phong = $_POST["id_phong"];
        $ds_cho = $_POST["ds_cho"];
        $currentDate = new DateTime();
        $kt_ngay_chieu = new DateTime($ngay_chieu);
        // nếu ngày điền vào nhỏ hơn ngày hiện tại sẽ lỗi
        if ($currentDate->format('Y-m-d') > $kt_ngay_chieu->format('Y-m-d')) {
            $_SESSION["thong_bao"] = "Phải nhập ngày hiện tại hoặc tương lai ";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {

            // nếu tòn tại id_lich_chieu thì nó là sửa hoặc xóa
            if (isset($_POST["id_lich_chieu"])) {

                $id_lich_chieu = $_POST["id_lich_chieu"];
                // nhận value từ btn
                if ($_POST["xu_ly"] == "sua") {

                    if ($rap_chieu != 'Nhóm 5') {
                        $_SESSION["thong_bao"] = "Các dữ liệu nhập không hợp lệ";
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    } elseif ($id_phong != '1' && $id_phong != '2') {

                        $_SESSION["thong_bao"] = "Các dữ liệu nhập không hợp lệ";

                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    }
                    $kt_trung_tg = false;
                    $id_lich_chieu_trung = 0;
                    $sql = "SELECT lc.id_lich_chieu as id_lich_chieu, lc.gio_chieu as gio_chieu, p.thoi_luong as thoi_luong FROM lich_chieu as lc INNER JOIN phim as p ON lc.id_phim = p.id_phim WHERE lc.id_phong = " . (int)$id_phong . " AND lc.ngay_chieu = '" . $ngay_chieu . "' AND lc.id_lich_chieu != " . (int)$id_lich_chieu;
                    $results = $conn->query($sql);
                    $results = $results->fetch_all(MYSQLI_ASSOC);

                    // Tách giờ và phút từ giờ chiếu mới
                    $tach_gio = explode(":", $gio_chieu);
                    $gio_chieu_phim = (int)$tach_gio[0]; // lấy giờ
                    $phut_chieu_phim = (int)$tach_gio[1]; // lấy phút
                    $tgc_phut = $gio_chieu_phim * 60 + $phut_chieu_phim; // Tổng thời gian tính theo phút

                    foreach ($results as $result) {
                        // Tách giờ và phút từ lịch chiếu hiện tại
                        $tach_gio = explode(":", $result["gio_chieu"]);
                        $gio_chieu_result = (int)$tach_gio[0];  // giờ lịch chiếu
                        $phut_chieu_phim_result = (int)$tach_gio[1];  // phút lịch chiếu

                        // Tính giờ bắt đầu và kết thúc của lịch chiếu
                        $gio_bat_dau = $gio_chieu_result * 60 + $phut_chieu_phim_result; // giờ bắt đầu của lịch chiếu
                        $gio_ket_thuc = $gio_bat_dau + $result["thoi_luong"] + 15; // giờ kết thúc của lịch chiếu + 15 phút chênh lệch

                        // Kiểm tra xem giờ chiếu mới có nằm trong phạm vi của lịch chiếu hiện tại không
                        if ($tgc_phut >= $gio_bat_dau && $tgc_phut <= $gio_ket_thuc) {
                            $kt_trung_tg = true;
                            $id_lich_chieu_trung = $result["id_lich_chieu"];
                            break;
                        }
                    }
                    // Cập nhật vào cơ sở dữ liệu
                    if (!$kt_trung_tg) {

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
                        $_SESSION["thong_bao"] = "Bị trùng thời gian với id lịch chiếu: " . $id_lich_chieu_trung;

                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    }
                }
                // xóa dữ liệu lịch chiếu
                else {
                    if (empty($ds_cho)) {
                        $sql = "DELETE FROM lich_chieu WHERE id_lich_chieu = " . (int)$id_lich_chieu;
                        if ($conn->query($sql)) {
                            $_SESSION["thong_bao"] = "Xóa thành công";

                            header("Location: " . $_SERVER['PHP_SELF']);
                            exit();
                        } else {
                            $_SESSION["thong_bao"] = "Xóa thất bại";

                            header("Location: " . $_SERVER['PHP_SELF']);

                            exit();
                        }
                    } else {
                        $_SESSION["thong_bao"] = "Thất bại danh sách chỗ đang không trống!";
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    }
                }
            }
            // thêm lịch chiếu
            else {
                $kt_trung_tg = false;
                $id_lich_chieu_trung = 0;
                $sql = "SELECT lc.id_lich_chieu as id_lich_chieu, lc.gio_chieu as gio_chieu, p.thoi_luong as thoi_luong FROM lich_chieu as lc INNER JOIN phim as p ON lc.id_phim = p.id_phim WHERE lc.id_phong = " . (int)$id_phong . " AND lc.ngay_chieu = '" . $ngay_chieu . "'";
                $results = $conn->query($sql);
                $results = $results->fetch_all(MYSQLI_ASSOC);

                // Tách giờ và phút từ giờ chiếu mới
                $tach_gio = explode(":", $gio_chieu);
                $gio_chieu_phim = (int)$tach_gio[0]; // lấy giờ
                $phut_chieu_phim = (int)$tach_gio[1]; // lấy phút
                $tgc_phut = $gio_chieu_phim * 60 + $phut_chieu_phim; // Tổng thời gian tính theo phút

                foreach ($results as $result) {
                    // Tách giờ và phút từ lịch chiếu hiện tại
                    $tach_gio = explode(":", $result["gio_chieu"]);
                    $gio_chieu_result = (int)$tach_gio[0];  // giờ lịch chiếu
                    $phut_chieu_phim_result = (int)$tach_gio[1];  // phút lịch chiếu

                    // Tính giờ bắt đầu và kết thúc của lịch chiếu
                    $gio_bat_dau = $gio_chieu_result * 60 + $phut_chieu_phim_result; // giờ bắt đầu của lịch chiếu
                    $gio_ket_thuc = $gio_bat_dau + $result["thoi_luong"] + 15; // giờ kết thúc của lịch chiếu + 15 phút chênh lệch

                    // Kiểm tra xem giờ chiếu mới có nằm trong phạm vi của lịch chiếu hiện tại không
                    if ($tgc_phut >= $gio_bat_dau && $tgc_phut <= $gio_ket_thuc) {
                        $kt_trung_tg = true;
                        $id_lich_chieu_trung = $result["id_lich_chieu"];
                        break;
                    }
                }
                // Cập nhật vào cơ sở dữ liệu
                if (!$kt_trung_tg) {
                    $sql = "SELECT * FROM phim WHERE id_phim = " . (int)$id_phim;
                    $results = $conn->query($sql);
                    if ($results->num_rows == 0) {
                        $_SESSION["thong_bao"] = "Không tồn tại id phim: " . $id_phim;
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    }
                    $sql = "INSERT INTO lich_chieu(id_phim, rap_chieu, ngay_chieu, gio_chieu, id_phong, ds_cho) VALUES(" . (int)$id_phim . ", '" . $rap_chieu . "' , '" . $ngay_chieu . "', '" . $gio_chieu . "' , '" . $id_phong . "', '')";

                    // Thực thi câu lệnh UPDATE
                    if ($conn->query($sql)) {
                        $_SESSION["thong_bao"] = "Thêm lịch chiếu thành công";

                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    } else {
                        $_SESSION["thong_bao"] = "Thêm lịch chiếu thất bại";

                        header("Location: " . $_SERVER['PHP_SELF']);

                        exit();
                    }
                } else {
                    $_SESSION["thong_bao"] = "Bị trùng thời gian với id lịch chiếu: " . $id_lich_chieu_trung;

                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                }
            }
        }
    } else {
        $_SESSION["thong_bao"] = "Không đủ dữ kiện";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
if (isset($_SESSION["user_id"])) {


    $user_id = $_SESSION["user_id"];
    // Kiểm tra quyền admin
    $sql = "SELECT is_admin from users where id = " . $user_id;
    $result = $conn->query($sql);
    $result = $result->fetch_all(MYSQLI_ASSOC)[0];
    $is_admin = $result["is_admin"];
    if ($is_admin) {
        // Lấy dữ liệu lịch chiếu
        $sql = "SELECT * FROM lich_chieu";
        $results = $conn->query($sql);
        $results = $results->fetch_all(MYSQLI_ASSOC);

        $lich_chieu = [];
        foreach ($results as $result) {
            $sql = "SELECT ten FROM phim WHERE id_phim = " . (int) $result["id_phim"];
            $r = $conn->query($sql);
            $r = $r->fetch_all(MYSQLI_ASSOC)[0];
            array_push($lich_chieu, [
                "id_lich_chieu" => $result["id_lich_chieu"],
                "id_phim" => $result["id_phim"],
                "ten_phim" => $r["ten"],
                "rap_chieu" => $result["rap_chieu"],
                "ngay_chieu" => $result["ngay_chieu"],
                "gio_chieu" => $result["gio_chieu"],
                "id_phong" => $result["id_phong"],
                "ds_cho" => $result["ds_cho"]
            ]);
        }
        $sql = "SELECT id_phong FROM `phong`";
        $results = $conn->query($sql);
        $ds_id_phong = $results->fetch_all(MYSQLI_ASSOC);
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

                .hidden {
                    display: none;
                }

                .form_tlc {
                    margin-top: 30px;
                }

                .form_tlc label {
                    display: block;
                    margin-bottom: 5px;
                }

                .form_tlc input {
                    display: block;
                    width: 100%;
                    padding: 8px;
                    margin-bottom: 10px;
                }

                select {
                    width: 100px;
                    margin-bottom: 60px;

                }

                .form_tlc button {
                    display: block;
                    width: 100%;
                    padding: 10px;
                    background-color: green;
                    color: white;
                    border: none;
                    cursor: pointer;
                }

                table button:hover {
                    cursor: pointer;
                }

                table {
                    margin-bottom: 100px;
                }

                table,
                th,
                td {
                    border: 1px solid black;
                    border-collapse: collapse;
                }

                th,
                td {
                    padding: 10px;
                }

                input {
                    border: 0;
                }

                table button {
                    width: 100%;
                    margin: 0;
                    padding: 0;
                    border: 0;
                    background-color: transparent;
                }

                table button:hover {
                    cursor: pointer;
                }

                form input {
                    border: 1px solid black;
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
            <a href="./index.php" style="margin-bottom: 20px;">Trang chủ</a>

            <div style="margin-bottom: 20px;">
                <button style="background-color: blueviolet; border: 0; padding: 5px;">
                    <a href="./admin_sp.php" style="text-decoration: none; color: white;">Sửa phim</a>
                </button>
                <button style="background-color: blueviolet; border: 0; padding: 5px;">
                    <a href="./admin_xn.php" style="text-decoration: none; color: white;">Xác nhận</a>
                </button>
            </div>

            <button id="them_lich_chieu">Điền thêm lịch chiếu</button>
            <form action="" method="post" class="form_tlc hidden">
                <label for="id_phim">Id phim</label>
                <input type="number" name="id_phim" id="id_phim" required>

                <label for="rap_chieu">Rạp chiếu</label>
                <input readonly type="text" name="rap_chieu" id="rap_chieu" value="Nhóm 5" required>

                <label for="ngay_chieu">Ngày chiếu</label>
                <input type="date" name="ngay_chieu" id="ngay_chieu" required>

                <label for="gio_chieu">Giờ chiếu</label>
                <input type="time" name="gio_chieu" id="gio_chieu" required>

                <label for="id_phong">Id phòng</label>
                <select name="id_phong" id="id_phong">
                    <?php foreach ($ds_id_phong as $ds) { ?>
                        <option value="<?php echo $ds["id_phong"]; ?>"><?php echo $ds["id_phong"]; ?></option>
                    <?php } ?>
                </select>
                <input type="hidden" name="ds_cho" value="" required>

                <button type="submit">Thêm lịch chiếu</button>
            </form>

            <h1>Sửa lịch chiếu</h1>
            <table border="1">
                <tr>
                    <td>Id lịch chiếu</td>
                    <td>Tên phim</td>
                    <td>Rạp Chiếu</td>
                    <td>Ngày Chiếu</td>
                    <td>Giờ Chiếu</td>
                    <td>Phòng Số</td>
                    <td>DS Chỗ</td>
                    <td>Sửa</td>
                    <td>Xóa</td>
                </tr>
                <?php foreach ($lich_chieu as $lc) { ?>
                    <form action="" method="post">
                        <tr>
                            <td>
                                <input type="text" name="id_lich_chieu" value="<?php echo $lc["id_lich_chieu"]; ?>">
                            </td>
                            <input type="hidden" name="id_phim" value="<?php echo $lc['id_phim']; ?>" required>
                            <td><input readonly type="text" name="ten_phim" value="<?php echo $lc['ten_phim']; ?>" required></td>
                            <td><input readonly type="text" name="rap_chieu" value="<?php echo $lc['rap_chieu']; ?>" required></td>
                            <td><input type="date" name="ngay_chieu" value="<?php echo $lc['ngay_chieu']; ?>" required></td>
                            <td><input type="time" name="gio_chieu" value="<?php echo $lc['gio_chieu']; ?>" required></td>
                            <td>
                                <select name="id_phong" id="id_phong" style="margin: 0;">
                                    <?php foreach ($ds_id_phong as $ds) { ?>
                                        <?php if ($lc["id_phong"] == $ds["id_phong"]) { ?>
                                            <option value="<?php echo $ds["id_phong"]; ?>" selected>
                                                <?php echo $ds["id_phong"]; ?>
                                            </option>
                                        <?php } else { ?>
                                            <option value="<?php echo $ds["id_phong"]; ?>">
                                                <?php echo $ds["id_phong"]; ?>
                                            </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </td>

                            <td><input readonly type="text" name="ds_cho" value="<?php echo $lc['ds_cho']; ?>" required></td>
                            <td><button type="submit" name="xu_ly" value="sua">Sửa</button></td>
                            <td><button type="submit" name="xu_ly" value="xoa">Xóa</button></td>
                        </tr>
                    </form>
                <?php } ?>
            </table>
            <script>
                document.querySelector("#them_lich_chieu").addEventListener("click", () => {
                    document.querySelector(".form_tlc").classList.toggle("hidden");
                })
            </script>
        </body>

        </html>
<?php } else {
        $_SESSION["ERR"] = "Bạn không có quyền truy cập trang này!";
        header("Location: ERR404.php");
    }
} else {
    $_SESSION["ERR"] = "Bạn chưa đăng nhập";
    header("Location: ERR404.php");
} ?>