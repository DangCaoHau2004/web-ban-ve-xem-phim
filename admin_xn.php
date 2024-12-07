<?php
function generateRandomString()
{
    $dskt = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $dskt_len = strlen($dskt);
    $randomString = '';
    for ($i = 0; $i < 8; $i++) {
        $randomString .= $dskt[rand(0, $dskt_len - 1)];
    }
    return $randomString;
}
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["btn"] == "xac_nhan") {
        if (isset($_POST['id_xn'], $_POST['id'], $_POST['id_lich_chieu'])) {
            $id_xn_rm = (int)$_POST['id_xn'];
            $id = (int)$_POST['id'];
            $id_lich_chieu = $_POST['id_lich_chieu'];
            // lấy id lịch chiếu và chỗ đã chọn
            $sql = "SELECT id_lich_chieu, cho_da_chon FROM `admin_xn` WHERE id_xn = " . (int)$id_xn_rm;
            $result = $conn->query($sql);
            $result = $result->fetch_all(MYSQLI_ASSOC)[0];
            $cho_da_chon = $result["cho_da_chon"];
            $id_lich_chieu = $result["id_lich_chieu"];
            // lấy ds chỗ
            $sql = "SELECT ds_cho FROM lich_chieu Where id_lich_chieu = " . $id_lich_chieu;
            $result = $conn->query($sql);
            $result = $result->fetch_all(MYSQLI_ASSOC)[0];
            $ds_cho = $result["ds_cho"];
            $ds_cho_arr = explode(" ", $ds_cho);
            print_r($ds_cho_arr);
            $kt_ton_tai = false;
            $cho_da_chon_arr = explode(" ", $cho_da_chon);
            print_r($cho_da_chon_arr);

            foreach ($cho_da_chon_arr as $seat) {
                if (in_array($seat, $ds_cho_arr)) {
                    $kt_ton_tai = true;
                }
            }
            if (!$kt_ton_tai) {
                if (!empty($ds_cho)) {
                    $ds_cho .= " " . $cho_da_chon;
                } else {
                    $ds_cho .= $cho_da_chon;
                }

                // cập nhật danh sách chỗ trong lịch chiếu
                $sql = "UPDATE lich_chieu SET ds_cho = '$ds_cho' WHERE id_lich_chieu = $id_lich_chieu";
                $conn->query($sql);

                while (true) {
                    $ma_ve = generateRandomString();
                    $sql = "SELECT * FROM admin_xn WHERE ma_ve = '" . $ma_ve . "'";
                    $result = $conn->query($sql);
                    $result = $result->fetch_all(MYSQLI_ASSOC);
                    if (empty($result)) {
                        break;
                    }
                }

                // cập nhật lại danh sách xác nhận
                $sql = "UPDATE admin_xn SET ma_ve = '" . $ma_ve . "', tinh_trang = 1 WHERE id_xn = " . (int)$id_xn_rm;
                $conn->query($sql);

                $_SESSION["thong_bao"] = "Thành Công";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                $sql = "UPDATE admin_xn SET tinh_trang = 2 WHERE id_xn = " . (int)$id_xn_rm;
                $conn->query($sql);

                $_SESSION["thong_bao"] = "Chỗ đã tồn tại";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        }
    } else {
        $id_xn_rm = (int)$_POST['id_xn'];
        $sql = "UPDATE admin_xn SET tinh_trang = 2 WHERE id_xn = " . (int)$id_xn_rm;
        $conn->query($sql);


        $_SESSION["thong_bao"] = "Đã hủy thành Công";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

$gia_ve = 50000;
$sql = "SELECT COUNT(*) AS so_hang FROM `admin_xn` WHERE tinh_trang = 0";
$results = $conn->query($sql);
$results = $results->fetch_all(MYSQLI_ASSOC)[0];
$so_hang = (int)$results["so_hang"];

$id_xn = [];
$id_lich_chieu = [];
$id_phong = [];
$cho_da_chon = [];
$ngay_chieu = [];
$gio_chieu = [];
$ten_phim = [];
$ds_cho = [];
$ngay_dat = [];
$id = [];
$ho_ten = [];
// Lấy dữ liệu từ bảng admin_xn
$sql = "SELECT 
    a.id_xn AS id_xn,
    l.id_lich_chieu AS id_lich_chieu, 
    l.id_phong AS id_phong, 
    a.cho_da_chon AS cho_da_chon, 
    l.ngay_chieu AS ngay_chieu, 
    l.gio_chieu AS gio_chieu, 
    p.ten AS ten_phim, 
    a.ngay_dat AS ngay_dat,
    u.id AS id,                 -- Thêm ID người dùng
    u.ho_ten AS ho_ten
FROM 
    admin_xn a
INNER JOIN 
    lich_chieu l ON a.id_lich_chieu = l.id_lich_chieu
INNER JOIN 
    phim p ON l.id_phim = p.id_phim
INNER JOIN 
    phong h ON l.id_phong = h.id_phong
INNER JOIN 
    users u ON a.id = u.id
WHERE 
    a.tinh_trang = 0;

";
$results = $conn->query($sql);
$results = $results->fetch_all(MYSQLI_ASSOC);


foreach ($results as $result) {
    array_push($id_xn, $result["id_xn"]);
    array_push($id_lich_chieu, $result['id_lich_chieu']);
    array_push($id_phong, $result['id_phong']);
    array_push($cho_da_chon, $result['cho_da_chon']);
    array_push($ngay_chieu, $result['ngay_chieu']);
    array_push($gio_chieu, $result['gio_chieu']);
    array_push($ten_phim, $result['ten_phim']);
    array_push($ds_cho, $result['cho_da_chon']);
    array_push(
        $ngay_dat,
        (new DateTime($result['ngay_dat']))->format("d/m/Y H:i:s")
    );
    array_push($id, $result['id']);
    array_push($ho_ten, $result['ho_ten']);
}

if (isset($_SESSION["user_id"])) {


    $user_id = $_SESSION["user_id"];
    // Kiểm tra quyền admin
    $sql = "SELECT is_admin from users where id = " . $user_id;
    $result = $conn->query($sql);
    $result = $result->fetch_all(MYSQLI_ASSOC)[0];
    $is_admin = $result["is_admin"];


    $is_admin = 1;
    if ($is_admin) {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Xác nhận</title>
            <style>
                body {
                    width: 100%;
                    height: auto;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                }

                form {
                    margin: 100px;
                }

                .hidden {
                    display: none;
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

                table {
                    margin-bottom: 100px;
                }

                input {
                    border: 0;
                }

                table,
                th,
                td {
                    border: 1px solid black;
                    border-collapse: collapse;
                }

                th,
                td {
                    padding: 5px;
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


            <div>
                <button style="background-color: blueviolet; border: 0; padding: 5px;">
                    <a href="./admin_sp.php" style="text-decoration: none; color: white;">Sửa phim</a>
                </button>
                <button style="background-color: blueviolet; border: 0; padding: 5px;">
                    <a href="./admin_slp.php" style="text-decoration: none; color: white;">Sửa lịch phim</a>
                </button>
            </div>

            <h1>Danh sách khác hàng đã xác nhận mua</h1>
            <table border="1">
                <tr>
                    <td>Id người đặt</td>
                    <td>Họ tên</td>
                    <td>Id lịch chiếu</td>
                    <td>Tên phim</td>
                    <td>Phòng</td>
                    <td>Giờ chiếu</td>
                    <td>Chỗ đã đặt</td>
                    <td>Giá vé</td>
                    <td>Ngày đặt</td>
                    <td>Nội dung chuyển khoản yêu cầu</td>
                    <td>Xác nhận</td>
                    <td>Hủy</td>
                </tr>
                <?php for ($i = 0; $i < $so_hang; $i++) {
                ?>
                    <form action="" method="post">

                        <tr>
                            <input type="text" hidden value=<?php echo $id_xn[$i] ?> name="id_xn">
                            <td><input type="text" readonly value=<?php echo $id[$i] ?> name="id"></td>
                            <td><?php echo $ho_ten[$i] ?></td>
                            <td><input type="text" readonly value=<?php echo $id_lich_chieu[$i] ?> name="id_lich_chieu"></td>
                            <td><?php echo $ten_phim[$i] ?></td>
                            <td>Phòng <?php echo $id_phong[$i] ?></td>
                            <td><?php echo $gio_chieu[$i] ?></td>
                            <td><?php echo $cho_da_chon[$i] ?></td>
                            <td>Tổng: <?php echo $gia_ve * count(explode(" ", $cho_da_chon[$i])) ?></td>
                            <td><?php echo $ngay_dat[$i] ?></td>
                            <td><?php echo $id[$i] . " " . $cho_da_chon[$i] . " " . $id_lich_chieu[$i] ?></td>
                            <td><button type="submit" value="xac_nhan" name="btn">Xác nhận</button></td>
                            <td><button type="submit" value="huy" name="btn">Hủy</button></td>
                        </tr>
                    </form>

                <?php } ?>
            </table>
        </body>
        <script>
            setTimeout('window.location.reload();', 30000)
        </script>

        </html>
<?php } else {
        $_SESSION["ERR"] = "Bạn không có quyền truy cập trang này!";
        header("Location: ERR404.php");
        exit();
    }
} else {
    $_SESSION["ERR"] = "Bạn không có quyền truy cập trang này!";
    header("Location: ERR404.php");
    exit();
} ?>