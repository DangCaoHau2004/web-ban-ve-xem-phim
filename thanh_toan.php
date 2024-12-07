<?php

include("database.php");
const gia_ve = 50000;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Lấy dữ liệu JSON từ body
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($_POST['unset_session'])) {
        unset($_SESSION['ds_cho']);
        unset($_SESSION['id_lich_chieu']);
        unset($_SESSION['selectedSeats']);
        header("Location: index.php");
        exit();
    } else if ($data !== null) {

        // Kiểm tra xem có dữ liệu ghế không    
        if (isset($data['seats'])) {
            $_SESSION['selectedSeats'] = $data['seats'];
            $_SESSION['id_lich_chieu'] = intval($data['id_lich_chieu']);
            exit();
        } else {
            http_response_code(404);
            $_SESSION["ERR"] = "Bạn chưa đặt chỗ!";
            exit();
        }
    } else {
        http_response_code(404);
        $_SESSION["ERR"] = "Thao tác không hợp lệ";
        exit();
    }
}

if (!isset($_SESSION['selectedSeats']) || !isset($_SESSION['id_lich_chieu'])) {
    http_response_code(404);

    $_SESSION["ERR"] = "Bạn chưa đặt ghế!";
    exit();
} else {
    //Cần điền id của user trong phiên
    if (isset($_SESSION["user_id"])) {

        $id = (int)$_SESSION["user_id"];
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Thanh Toán</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f0f0f0;
                    margin: 0;
                    padding: 20px;
                }

                .container {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    height: auto;
                    text-align: center;
                    background-color: #ffffff;
                    border-radius: 10px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    padding: 20px;
                }

                .container img {
                    max-width: 80%;
                    height: auto;
                    border-radius: 5px;
                    margin-bottom: 20px;
                }



                a,
                button {
                    margin: 30px 0px;
                    text-decoration: none;
                    padding: 10px;
                    background-color: purple;
                    border-radius: 5px;
                    color: white;
                    border: 0px;
                }
            </style>
        </head>

        <body>
            <!-- nếu như tồn tại các ghế đã chọn và id lịch chiếu  -->
            <?php if (isset($_SESSION['selectedSeats']) && isset($_SESSION['id_lich_chieu'])) {
            ?>
                <?php
                $sql = "SELECT ds_cho FROM lich_chieu Where id_lich_chieu = " . $_SESSION['id_lich_chieu'];
                $result = $conn->query($sql);
                $lich_chieu = $result->fetch_all(MYSQLI_ASSOC)[0];
                $ds_cho = $lich_chieu["ds_cho"];
                if (!empty($ds_cho)) {
                    $selectedSeats = " " . implode(" ", $_SESSION['selectedSeats']);
                } else {
                    $selectedSeats = implode(" ", $_SESSION['selectedSeats']);
                }
                $ds_cho .= $selectedSeats;
                ?>


                <div class="container">
                    <h1 style="color: red; margin: 0;">Bạn lưu ý vui lòng ghi nội dung chuyển khoản là: "<?php
                                                                                                            echo $id . " " . implode(", ", $_SESSION['selectedSeats'])
                                                                                                                . " " . $_SESSION['id_lich_chieu'];
                                                                                                            ?>" </h1>
                    <img src="./img/qr.jpg" alt="QR Code">
                    <h2>Các ghế đã đặt:
                        <?php
                        echo implode(", ", $_SESSION['selectedSeats']);
                        ?>
                    </h2>
                    <h2>Tổng số tiền:
                        <?php
                        echo count($_SESSION['selectedSeats']) * gia_ve;
                        ?></h2>

                    <button id="submit">Đã Thanh Toán</button>
                    <form method="post" action="">
                        <button type="submit" name="unset_session">Hủy Bỏ</button>
                    </form>
                </div>
                <!-- truyền dữ liệu ds_cho js ???-->
                <?php echo "<script>var ds_cho = '" . $ds_cho . "';</script>"; ?>

            <?php } else { ?>
                <!-- Không tồn tại id lịch chiếu và chỗ ngồi  -->
            <?php
                unset($_SESSION['ds_cho']);
                unset($_SESSION['id_lich_chieu']);
                unset($_SESSION['selectedSeats']);
                $_SESSION['ERR'] = "Hãy chọn phim để có thể thanh toán!";
                header("Location: ERR404.php");
            } ?>

            <script>
                document.getElementById("submit").addEventListener("click", () => {
                    fetch("dien_cho.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json; charset=utf-8",
                            },
                            body: JSON.stringify({
                                ds_cho: ds_cho,
                            }),
                        })
                        .then((response) => {
                            if (!response.ok) {
                                throw new Error("");
                            } else {
                                alert("Bạn đã đặt mua vé thành công, vé sẽ được duyệt trong 2-3 phút, vui lòng kiểm tra thông tin vé trong trang thông tin cá nhân!");
                                location.replace("/web-ban-ve-xem-phim/index.php");
                            }
                        })
                        .catch((error) => {
                            location.replace("/web-ban-ve-xem-phim/ERR404.php");
                        });
                })
            </script>
        </body>

        </html>
<?php

    } else {
        $_SESSION["ERR"] = "Bạn chưa đăng nhập!";
        header("Location: ERR404.php");
        exit();
    }
}
?>