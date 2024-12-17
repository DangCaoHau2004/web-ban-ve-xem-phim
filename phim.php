<?php
include("navbar.php");
$sql = "SELECT id_phim, ten, the_loai, thoi_luong, link_img, mo_ta, ngon_ngu, img_background FROM phim";
$results = $conn->query($sql);
$results = $results->fetch_all(MYSQLI_ASSOC);
$ds_phim = [];

$phim = [];
foreach ($results as $result) {
    array_push($ds_phim, [
        "id_phim" => $result["id_phim"],
        "ten" => $result["ten"],
        "the_loai" => $result["the_loai"],
        "thoi_luong" => $result["thoi_luong"],
        "link_img" => $result["link_img"],
        "mo_ta" => $result["mo_ta"],
        "ngon_ngu" => $result["ngon_ngu"],
    ]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinemar - Danh Sách Phim</title>

    <title>Phim</title>

    <style>
        /* Cấu trúc cơ bản */

        .body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        #movie-list {
            display: grid;
            grid-template-columns: repeat(3, auto);
            grid-template-rows: repeat(<?php echo (int) ceil(count($ds_phim) / 3); ?>, 1fr);
            gap: 50px;
            width: fit-content;
            margin: 0 auto;
        }

        .movie-item {
            width: 300px;
            height: 100%;
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
            font-size: 16px;
            color: #777;

        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <section id="movie-list" class="movie-list">
        <?php foreach ($ds_phim as $phim) {
        ?>
            <a href=<?php echo "/web-ban-ve-xem-phim/chi_Tiet_Phim.php?id_phim="  . $phim["id_phim"] ?>>
                <div class="movie-item">
                    <img src=<?php echo $phim["link_img"] ?>>
                    <h3><?php echo $phim["ten"] ?></h3>
                    <p><?php echo $phim["mo_ta"] ?></p>
                </div>
            </a>
        <?php
        } ?>

    </section>
</body>

</html>
<?php include("foot.php") ?>