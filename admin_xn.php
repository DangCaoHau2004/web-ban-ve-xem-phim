<?php
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_xn'])) {
        $id_xn_rm = $_POST['id_xn'];

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
            echo "Thành công";
            $sql = "UPDATE lich_chieu SET ds_cho = '$ds_cho' WHERE id_lich_chieu = $id_lich_chieu";
            $conn->query($sql);

            $sql = "UPDATE admin_xn SET tinh_trang = '1' WHERE id_xn = " . (int)$id_xn_rm;
            $conn->query($sql);
        } else {
            $sql = "UPDATE admin_xn SET tinh_trang = '2' WHERE id_xn = " . (int)$id_xn_rm;
            $conn->query($sql);
        }
    }

    //nếu ko có header ở đây thì khi reload lại trang nó vẫn là method post và tự động cập nhật lại các giá trị dựa trên dữ liệu cũ!
    header("Location: " . $_SERVER['PHP_SELF']);
}

$gia_ve = 50000;
$sql = "SELECT COUNT(*) AS so_hang FROM `admin_xn` WHERE tinh_trang = 0";
$results = $conn->query($sql);
$results = $results->fetch_all(MYSQLI_ASSOC)[0];
$so_hang = (int)$results["so_hang"];

$hoten = "Đặng Cao Hậu";
$id_xn = [];
$id_lich_chieu = [];
$id_phong = [];
$cho_da_chon = [];
$ngay_chieu = [];
$gio_chieu = [];
$ten = [];
$ds_cho = [];
$ngay_dat = [];
// Lấy dữ liệu từ bảng admin_xn
$sql = "SELECT 
    a.id_xn AS id_xn,
    l.id_lich_chieu AS id_lich_chieu, 
    l.id_phong AS id_phong, 
    a.cho_da_chon as cho_da_chon, 
    l.ngay_chieu AS ngay_chieu, 
    l.gio_chieu AS gio_chieu, 
    p.ten AS ten,
    a.ngay_dat AS ngay_dat
FROM 
    admin_xn a
INNER JOIN 
    lich_chieu l ON a.id_lich_chieu = l.id_lich_chieu
INNER JOIN 
    phim p ON l.id_phim = p.id_phim
INNER JOIN 
    phong h ON l.id_phong = h.id_phong
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
    array_push($ten, $result['ten']);
    array_push($ds_cho, $result['cho_da_chon']);
    array_push(
        $ngay_dat,
        (new DateTime($result['ngay_dat']))->format("d/m/Y H:i:s")
    );
}

// id_user
$id_user = 1;

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
        </style>
    </head>

    <body>
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
                <td>STT</td>
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
            </tr>
            <?php for ($i = 0; $i < $so_hang; $i++) {
            ?>
                <form action="" method="post">

                    <tr>
                        <input type="text" hidden value=<?php echo $id_xn[$i] ?> name="id_xn">
                        <td><?php echo $i + 1 ?></td>
                        <td><?php echo $hoten ?></td>
                        <td><?php echo $id_lich_chieu[$i] ?></td>
                        <td><?php echo $ten[$i] ?></td>
                        <td>Phòng <?php echo $id_phong[$i] ?></td>
                        <td><?php echo $gio_chieu[$i] ?></td>
                        <td><?php echo $cho_da_chon[$i] ?></td>
                        <td>Tổng: <?php echo $gia_ve * count(explode(" ", $cho_da_chon[$i])) ?></td>
                        <td><?php echo $ngay_dat[$i] ?></td>
                        <td><?php echo $id_user . " " . $cho_da_chon[$i] . " " . $id_lich_chieu[$i] ?></td>
                        <td><button type="submit">Xác nhận</button></td>
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
} ?>