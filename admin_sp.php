<?php

include("./database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["ten"], $_POST["the_loai"], $_POST["thoi_luong"], $_POST["link_img"], $_POST["mo_ta"], $_POST["ngon_ngu"])) {
        $ten = $_POST["ten"];
        $the_loai = $_POST["the_loai"];
        $thoi_luong = $_POST["thoi_luong"];
        $link_img = $_POST["link_img"];
        $mo_ta = $_POST["mo_ta"];
        $ngon_ngu = $_POST["ngon_ngu"];
        // nếu tồn tại id_phim thì nó là sửa hoặc xóa phim
        if (isset($_POST["id_phim"])) {
            $id_phim = $_POST["id_phim"];
            //sửa
            if ($_POST["sua_phim"] == "sua") {


                $sql = "UPDATE phim SET 
                            ten = '" . $ten . "', 
                            the_loai = '" . $the_loai . "', 
                            thoi_luong = '" . $thoi_luong . "', 
                            link_img = '" . $link_img . "', 
                            mo_ta = '" . $mo_ta . "', 
                            ngon_ngu = '" . $ngon_ngu . "' 
                        WHERE id_phim = " . $id_phim;

                if ($conn->query($sql)) {
                    $_SESSION["thong_bao"] = "Thành Công";
                } else {
                    $_SESSION["thong_bao"] = 'Thất Bại';
                }

                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
            //xóa 
            else {
                $sql = "SELECT * FROM lich_chieu WHERE id_phim = " . (int)$id_phim;
                $results = $conn->query($sql);
                $results = $results->fetch_all(MYSQLI_ASSOC);
                if (!empty($results)) {
                    $_SESSION["thong_bao"] = 'Phim hiện tại đang được chiếu! Không thể xóa';
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                } else {
                    $sql = "DELETE FROM phim WHERE id_phim = " . (int)$id_phim;
                    if ($conn->query($sql)) {
                        $_SESSION["thong_bao"] = "Xóa phim thành công ";

                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    } else {
                        $_SESSION["thong_bao"] = "Xóa phim thất bại";

                        header("Location: " . $_SERVER['PHP_SELF']);

                        exit();
                    }
                }
            }
        }
        // nếu ko có id phim thì là điền thêm        
        else {
            $sql = "INSERT INTO phim (ten, the_loai, thoi_luong, link_img, mo_ta, ngon_ngu) VALUES ('" . $ten . "', '" . $the_loai . "', " . (int)$thoi_luong . ", '" . $link_img . "', '" . $mo_ta . "', '" . $ngon_ngu . "')";
            if ($conn->query($sql)) {
                $_SESSION["thong_bao"] = "Thêm phim thành công ";

                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                $_SESSION["thong_bao"] = "Thêm phim thất bại";

                header("Location: " . $_SERVER['PHP_SELF']);

                exit();
            }
        }
    } else {
        $_SESSION["thong_bao"] = 'Dữ liệu không đầy đủ!';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

$is_admin = 1;

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

            .them_phim_form * {
                display: block;
                margin: 10px;
            }

            .hidden {
                display: none;
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

        <div style="margin-bottom: 20px;">
            <button style="background-color: blueviolet; border: 0; padding: 5px;">
                <a href="./admin_xn.php" style="text-decoration: none; color: white;">Xác nhận</a>
            </button>
            <button style="background-color: blueviolet; border: 0; padding: 5px;">
                <a href="./admin_slp.php" style="text-decoration: none; color: white;">Sửa lịch phim</a>
            </button>
        </div>
        <!-- thêm phim  -->
        <button id="them_phim">Thêm Phim</button>
        <form action="" method="post" class="them_phim_form hidden">
            <label for="">Tên Phim</label>
            <input type="text" name="ten" required>
            <label for="">Thể loại</label>
            <input type="text" name="the_loai" required>
            <label for="">Thời lượng</label>
            <input type="text" name="thoi_luong" required>
            <label for="">Link img</label>
            <input type="text" name="link_img" required>
            <label for="">Mô tả</label>
            <input type="text" name="mo_ta" required>
            <label for="">Ngôn ngữ</label>
            <input type="text" name="ngon_ngu" required>
            <button type="submit">Xác nhận</button>
        </form>
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
                <td>Xóa phim</td>
            </tr>
            <?php foreach ($ds_phim as $ds_p) { ?>
                <form action="" method="post">
                    <tr>
                        <td><input type="text" readonly name="id_phim" value="<?php echo $ds_p["id_phim"]; ?>" required></td>
                        <td><input type="text" name="ten" value="<?php echo $ds_p["ten"]; ?>" required></td>
                        <td><input type="text" name="the_loai" value="<?php echo $ds_p["the_loai"]; ?>" required></td>
                        <td><input type="text" name="thoi_luong" value="<?php echo $ds_p["thoi_luong"]; ?>" required></td>
                        <td><input type="text" name="link_img" value="<?php echo $ds_p["link_img"]; ?>" required></td>
                        <td><input type="text" name="mo_ta" value="<?php echo $ds_p["mo_ta"]; ?>" required></td>
                        <td><input type="text" name="ngon_ngu" value="<?php echo $ds_p["ngon_ngu"]; ?>" required></td>
                        <td><button type="submit" name="sua_phim" value="sua">Sửa</button></td>
                        <td><button type="submit" name="sua_phim" value="xoa">Xóa</button></td>
                    </tr>
                </form>
            <?php } ?>
        </table>
        <script>
            document.querySelector("#them_phim").addEventListener("click", () => {
                document.querySelector(".them_phim_form").classList.toggle("hidden");
            })
        </script>
    </body>

    </html>

<?php } else {
    $_SESSION["ERR"] = "Bạn không có quyền truy cập trang này!";
    header("Location: ERR404.php");
    exit();  // Dừng ngay sau khi chuyển hướng
} ?>