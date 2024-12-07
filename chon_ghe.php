<?php
include("navbar.php");

if (isset($_GET["id_lich_chieu"])) {

    $id_lich_chieu = $_GET["id_lich_chieu"];
    $nameArr = 65;
    $sql = "SELECT id_phim, rap_chieu, ngay_chieu, gio_chieu, id_phong, ds_cho FROM lich_chieu Where id_lich_chieu = " . $id_lich_chieu;
    if ($conn->query($sql)) {
        $result = $conn->query($sql);
        $lich_chieu = $result->fetch_all(MYSQLI_ASSOC)[0];
        $sql = "SELECT so_hang, so_cot FROM phong WHERE id_phong = " . $lich_chieu["id_phong"];
        $result = $conn->query($sql);
        $ds_hang_cot = $result->fetch_all(MYSQLI_ASSOC)[0];
        $row = (int)$ds_hang_cot["so_hang"];
        $column = (int)$ds_hang_cot["so_cot"];
        $sql = "SELECT ten, the_loai, thoi_luong, link_img FROM phim WHERE id_phim = " . $lich_chieu["id_phim"];
        $result = $conn->query($sql);
        $phim = $result->fetch_all(MYSQLI_ASSOC)[0];
        $tt_phim = [
            'link_img' => $phim['link_img'],
            'ten_phim' => $phim['ten'],
            'the_loai' => $phim['the_loai'],
            'thoi_luong' => $phim['thoi_luong'],
            'rap_chieu' => $lich_chieu['rap_chieu'],
            'ngay_chieu' => (new DateTime($lich_chieu['ngay_chieu']))->format("d/m/Y"),
            'gio_chieu' => $lich_chieu['gio_chieu'],
            'phong' => $lich_chieu['id_phong'],
        ];
        $ds_cho = explode(" ", $lich_chieu["ds_cho"]);
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Rạp Chiếu Phim</title>
            <link rel="stylesheet" href="./style.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <style>
                .cinema-sitting {
                    display: grid;
                    grid-template-columns: repeat(<?php echo $column; ?>, 30px);
                    grid-template-rows: repeat(<?php echo $row; ?>, 30px);
                    gap: 10px;
                    width: fit-content;
                    margin: 0 auto;
                }

                body {
                    background-color: #f4f4f4;
                }

                .body-page {
                    width: 80%;
                    display: grid;
                    grid-template-columns: 2fr 1fr;
                    gap: 5%;
                    margin: 100px;
                    justify-content: space-between;
                }

                /* cấu trúc rạp  */
                .seating-chart {
                    overflow-x: auto;
                    overflow-y: hidden;
                    display: grid;
                    grid-template-rows: min-content auto;
                    grid-template-columns: 1fr;
                    background-color: transparent;
                }

                /* màn hình  */
                .cinema-screen {}

                /* ảnh màn hình */
                .cinema-screen img {
                    width: 100%;
                }

                /* bảng danh sách ghế */
                .cinema-sitting {}

                /* tùy chỉnh các ghế */
                .seat-cell {
                    position: relative;
                    align-self: center;
                }

                /* căn chỉnh chữ trên ghế */
                .seat-cell p {
                    margin: 0;
                    padding: 0;
                    width: 100%;
                    height: 100%;
                    text-align: center;
                    position: absolute;
                    top: 5%;
                    left: 0%;
                    font-size: 14px;
                }

                /* ảnh của div ghế */
                .seat-cell-img {
                    width: 30px;
                    height: 30px;
                    background-image: url("./img/seat-unselect-normal.png");
                    background-size: cover;
                }

                .seat-buy-cell-img {
                    width: 30px;
                    height: 30px;
                    background-image: url("./img/seat-buy-normal.png");
                    background-size: cover;
                }

                /* sau khi select thì đổi */
                .selected .seat-cell-img {
                    background-image: url("./img/seat-select-normal.png");
                }

                .selected p {
                    color: white;
                }

                /* thông tin phim */
                .film-information {
                    display: grid;
                    height: 100vh;
                    grid-template-rows: 1fr 1fr;
                    gap: 5%;
                    padding: 10px;
                    border-radius: 20px;
                    background-color: white;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                }

                /* tên film và img  */
                .title {
                    width: 100%;
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 5%;
                    border-bottom: 1px dashed black;
                }

                .title img {
                    width: 100%;
                    border-radius: 5%;
                }

                .title .name-film h3 {
                    margin: 0;
                    padding: 0;
                }

                /* thông tin của film  */
                .film-information .information {
                    display: grid;
                    grid-template-rows: repeat(7, 1fr);
                    gap: 5%;
                }

                /* toàn bộ các dòng  */
                .film-information .information>* {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    grid-template-rows: min-content;
                    gap: 5%;
                }

                /* tùy chỉnh chữ trong thông tin film  */
                .film-information .information p {
                    padding: 0;
                    margin: 0;
                }

                /* nút mua vé  */
                .film-information button {
                    justify-self: center;
                    width: 30%;
                    border: 0px;
                    border-radius: 5px;
                    padding: 5px;
                    background-color: rgb(128, 128, 195);
                }

                @media (max-width: 800px) {
                    .body-page {
                        display: block;
                        width: 100%;
                        margin: 0;
                    }

                    .seating-chart {
                        overflow-x: auto;
                        overflow-y: hidden;
                        display: grid;
                        grid-template-rows: min-content auto;
                        grid-template-columns: 1fr;
                        background-color: transparent;
                        width: 100%;
                        margin: 100px 0px;
                    }

                    body {
                        margin: 0;
                    }

                    .film-information {
                        display: grid;
                        height: 100vh;
                        grid-template-rows: 1fr 1fr;
                        gap: 5%;
                        padding: 10px;
                        border: 0;
                        background-color: transparent;
                        margin-bottom: 100px;
                        box-shadow: none;
                    }

                    .title {
                        width: 100%;
                        display: grid;
                        grid-template-columns: 1fr 1fr;
                        gap: 5%;
                        border-bottom: 0;
                    }
                }
            </style>

        <body>
            <div class="body-page">
                <input type="hidden" class="id_lich_chieu" name="id_lich_chieu" value=<?php echo $id_lich_chieu ?>>
                <div class="seating-chart">
                    <div class="cinema-screen">
                        <img src="./img/ic-screen.png" alt="screen">
                    </div>
                    <div class="cinema-sitting">

                        <?php for ($r = 0; $r < $row; $r++) { ?>
                            <?php for ($c = 0; $c < $column; $c++) { ?>
                                <div class="seat-cell">
                                    <?php if (in_array(chr($nameArr + $r) . ($c + 1), $ds_cho)) { ?>
                                        <div class="seat-buy-cell-img"></div>
                                        <p><?php echo chr($nameArr + $r) . ($c + 1) ?></p>
                                    <?php } else { ?>
                                        <div class="seat-cell-img"></div>
                                        <p><?php echo chr($nameArr + $r) . ($c + 1) ?></p>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="film-information">
                    <div class="title">
                        <img src=<?php echo $tt_phim["link_img"] ?> alt="">
                        <div class="name-film">
                            <h3><?php echo $tt_phim["ten_phim"] ?></h3>
                            <p>2D Phụ đề</p>
                        </div>
                    </div>
                    <div class="information">
                        <div class="genre">
                            <p><i class="fa-solid fa-tag" style="color: #000000;"></i> Thể Loại:</p>
                            <p><?php echo $tt_phim["the_loai"] ?></p>
                        </div>
                        <div class="duration">
                            <p><i class="fa-regular fa-clock"></i> Thời lượng:</p>
                            <p><?php echo $tt_phim["thoi_luong"] ?> Phút</p>
                        </div>
                        <div class="cinema">
                            <p><i class="fa-solid fa-house"></i> Rạp chiếu:</p>
                            <p><?php echo $tt_phim["rap_chieu"] ?></p>
                        </div>
                        <div class="release-date">
                            <p><i class="fa-regular fa-calendar-days"></i> Ngày chiếu:</p>
                            <p><?php echo $tt_phim["ngay_chieu"] ?></p>
                        </div>
                        <div class="show-time">
                            <p><i class="fa-regular fa-clock"></i> Giờ chiếu:</p>
                            <p><?php echo $tt_phim["gio_chieu"] ?></p>
                        </div>
                        <div class="auditorium">
                            <p><i class="fa-solid fa-laptop"></i> Phòng chiếu:</p>
                            <p>P<?php echo $tt_phim["phong"] ?></p>
                        </div>
                        <div class="seat">
                            <p><i class="fa-solid fa-boxes-stacked"></i> Ghế ngồi:</p>
                            <p></p>
                        </div>
                    </div>
                    <button class="submit">Mua vé</button>

                </div>
            </div>
            <?php include("foot.php") ?>
            <script>
                let selectedSeat = [];

                document.querySelectorAll(".seat-cell").forEach((seat) => {
                    seat.addEventListener("click", (event) => {
                        if (!seat.querySelector(".seat-buy-cell-img")) {
                            seat.classList.toggle("selected");
                            var seatNumber = seat.querySelector("p").textContent;

                            if (selectedSeat.includes(seatNumber)) {
                                selectedSeat = selectedSeat.filter((seat) => seat !== seatNumber);
                            } else {
                                selectedSeat.push(seatNumber);
                            }

                            document.querySelector(
                                ".film-information .information .seat"
                            ).lastElementChild.innerHTML = selectedSeat.join(", ");
                        }
                    });
                });
                // có thể dùng php để post nhưng tôi muốn có alert sau khi xong nên tôi dùng js 

                document.querySelector(".submit").addEventListener("click", () => {
                    let id_lich_chieu = document.querySelector(".id_lich_chieu").value;
                    if (selectedSeat.length !== 0 && id_lich_chieu) {
                        fetch("thanh_toan.php", {
                                method: "POST",
                                headers: {
                                    // định dạng dữ liệu truyền đi là json và mã hóa utf-8
                                    "Content-Type": "application/json; charset=utf-8",
                                },
                                // chuyển từ một chuỗi thành json
                                body: JSON.stringify({
                                    seats: selectedSeat,
                                    id_lich_chieu: id_lich_chieu
                                }), // Gửi dữ liệu ghế ngồi
                            })
                            .then((response) => {
                                if (!response.ok) {
                                    throw new Error("");
                                }
                                return response.text();
                            })
                            .then((data) => {
                                location.replace("/web-ban-ve-xem-phim/thanh_toan.php");
                            })
                            .catch((error) => {
                                location.replace("/web-ban-ve-xem-phim/ERR404.php");
                            });
                    } else {
                        alert("Bạn chưa chọn chỗ");
                    }
                });
            </script>

        </body>

        </html>
<?php } else {
        $_SESSION["ERR"] = "Phim không tồn tại.";
        header("Location: ERR404.php");
    }
} else {
    $_SESSION["ERR"] = "Phim không tồn tại.";
    header("Location: ERR404.php");
} ?>