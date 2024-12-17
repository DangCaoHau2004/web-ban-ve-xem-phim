<?php
$id_phim = 1;
include("database.php");

if (isset($GET["id_phim"])) {
    $id_phim = $_GET["id_phim"];
    $nameArr = 65;
    $sql = "SELECT id_phim, ten, the_loai, thoi_luong, link_img, mo_ta, ngon_ngu, img_background FROM phim Where id_phim =" . $id_phim;
    $results = $results->fetch_all(MYSQLI_ASSOC)[0];
    $phim = [
        "id_phim" => $results["id_phim"],
        "ten" => $results["ten"],
        "the_loai" => $results["the_loai"],
        "thoi_luong" => $results["thoi_luong"],
        "link_img" => $results["link_img"],
        "mo_ta" => $results["mo_ta"],
        "ngon_ngu" => $results["ngon_ngu"],
        "img_background" => $results["img_background"],
    ];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <<<<<<< HEAD
        <title>Cinemar - Danh Sách Phim</title>

        =======
        <title>Phim</title>
        >>>>>> 734d2d0c96d318f86ab9b98e31e6127f733e4225

        <style>
            /* Cấu trúc cơ bản */
            .cinema-sitting {
                display: grid;
                grid-template-columns: repeat(<?php echo $column; ?>, 30px);
                grid-template-rows: repeat(<?php echo $row; ?>, 30px);
                gap: 10px;
                width: fit-content;
                margin: 0 auto;
            }

            .body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }

            #movie-list {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                padding: 20px;
                justify-content: center;
            }

            .movie-item {
                width: 200px;
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                text-align: center;
                padding: 10px;
                transition: transform 0.3s ease;
            }

            .movie-item img {
                width: 100%;
                height: 300px;
                object-fit: cover;
                border-radius: 10px;
            }

            .movie-item h3 {
                font-size: 18px;
                margin: 10px 0;
            }

            .movie-item p {
                font-size: 14px;
                color: #777;
            }

            .movie-item:hover {
                transform: translateY(-10px);
            }

            .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0, 0, 0, 0.4);
            }

            .modal-content {
                background-color: #fefefe;
                margin: 15% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
                max-width: 600px;
            }

            .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }
        </style>
</head>

<body>
    <section id="movie-list" class="movie-list">
        <!-- Danh sách phim sẽ được JavaScript điền vào đây -->
    </section>
    < id="movie-detail-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="movie-title-detail"></h2>
            <img id="movie-img-detail" src="" alt="Phim Chi Tiết">
            <p id="movie-description-detail"></p>
            <p><strong>Thể loại:</strong> <span id="movie-genre-detail"></span></p>
            <p><strong>Đánh giá:</strong> <span id="movie-rating-detail"></span></p>
        </div>
        <div class="cinema-sitting">
        </div>
</body>

</html>