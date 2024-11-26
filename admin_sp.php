<?php

include("./database.php");
//abc
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id_phim"], $_POST["ten"], $_POST["the_loai"], $_POST["thoi_luong"], $_POST["link_img"], $_POST["mo_ta"], $_POST["ngon_ngu"])) {
        $id_phim = $_POST["id_phim"];
        $ten = $conn->real_escape_string($_POST["ten"]);
        $the_loai = $conn->real_escape_string($_POST["the_loai"]);
        $thoi_luong = $conn->real_escape_string($_POST["thoi_luong"]);
        $link_img = $conn->real_escape_string($_POST["link_img"]);
        $mo_ta = $conn->real_escape_string($_POST["mo_ta"]);
        $ngon_ngu = $conn->real_escape_string($_POST["ngon_ngu"]);

        // Câu lệnh UPDATE
        $sql = "UPDATE phim SET 
                    ten = '$ten', 
                    the_loai = '$the_loai', 
                    thoi_luong = '$thoi_luong', 
                    link_img = '$link_img', 
                    mo_ta = '$mo_ta', 
                    ngon_ngu = '$ngon_ngu' 
                WHERE id_phim = $id_phim";

        if ($conn->query($sql)) {
            $_SESSION["thong_bao"] = "Thành Công";
        } else {
            $_SESSION["thong_bao"] = 'Thất Bại';
        }

        // Chuyển hướng sau khi thay đổi dữ liệu
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();  // Dừng ngay sau khi chuyển hướng
    } else {
        $_SESSION["thong_bao"] = 'Dữ liệu không đầy đủ!';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();  // Dừng ngay sau khi chuyển hướng
    }
}

$is_admin = 1;  // Kiểm tra nếu người dùng là admin

if ($is_admin) {
    $sql = "SELECT * FROM `phim`";
    $results = $conn->query($sql);
    $results = $results->fetch_all(MYSQLI_ASSOC);
    $ds_phim = [];
    foreach ($results as $result) {
        array_push($ds_phim, [
            "id_phim" => $result["id_phim"],
            "ten" => $result["ten"],
            "the_loai" => $result["the_loai"],
            "thoi_luong" => $result["thoi_luong"],
            "link_img" => $result["link_img"],
            "mo_ta" => $result["mo_ta"],
            "ngon_ngu" => $result["ngon_ngu"]
        ]);
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sửa phim</title>
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
        <?php if (isset($_SESSION["thong_bao"])) { ?>
            <script>
                alert('<?php echo $_SESSION["thong_bao"]; ?>');
            </script>
            <?php unset($_SESSION["thong_bao"]);
            ?>
        <?php } ?>

        <div>
            <button style="background-color: blueviolet; border: 0; padding: 5px;">
                <a href="./admin_xn.php" style="text-decoration: none; color: white;">Xác nhận User đã đặt</a>
            </button>
            <button style="background-color: blueviolet; border: 0; padding: 5px;">
                <a href="./admin_slp.php" style="text-decoration: none; color: white;">Sửa lịch phim</a>
            </button>
        </div>

        <h1>Danh sách các phim</h1>
        <table border="1">
            <tr>
                <td>Id phim</td>
                <td>Tên Phim</td>
                <td>Thể Loại</td>
                <td>Thời Lượng</td>
                <td>Link img</td>
                <td>Mô tả</td>
                <td>Ngôn ngữ</td>
                <td>Sửa phim</td>
            </tr>
            <?php foreach ($ds_phim as $ds_p) { ?>
                <form action="" method="post">
                    <tr>
                        <td><input type="text" readonly name="id_phim" value="<?php echo $ds_p["id_phim"]; ?>"></td>
                        <td><input type="text" name="ten" value="<?php echo $ds_p["ten"]; ?>"></td>
                        <td><input type="text" name="the_loai" value="<?php echo $ds_p["the_loai"]; ?>"></td>
                        <td><input type="text" name="thoi_luong" value="<?php echo $ds_p["thoi_luong"]; ?>"></td>
                        <td><input type="text" name="link_img" value="<?php echo $ds_p["link_img"]; ?>"></td>
                        <td><input type="text" name="mo_ta" value="<?php echo $ds_p["mo_ta"]; ?>"></td>
                        <td><input type="text" name="ngon_ngu" value="<?php echo $ds_p["ngon_ngu"]; ?>"></td>
                        <td><button type="submit">Sửa</button></td>
                    </tr>
                </form>
            <?php } ?>
        </table>

    </body>

    </html>

<?php } else {
    $_SESSION["ERR"] = "Bạn không có quyền truy cập trang này!";
    header("Location: ERR404.php");
    exit();  // Dừng ngay sau khi chuyển hướng
} ?>