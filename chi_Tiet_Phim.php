<?php
$id_phim = 3;
include("database.php");
$results =  $conn->query("SELECT ten, the_loai, thoi_luong, link_img, mo_ta, ngon_ngu FROM phim WHERE id_phim = " . $id_phim);
$results = $results->fetch_all(MYSQLI_ASSOC)[0];
$chi_tiet_phim = [
  "ten" => $results["ten"],
  "the_loai" => $results["the_loai"],
  "thoi_luong" => $results["thoi_luong"],
  "link_img" => $results["link_img"],
  "mo_ta" => $results["mo_ta"],
  "ngon_ngu" => $results["ngon_ngu"],
]
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chi Tiết Phim - Cô Dâu Hào Môn | Beat Cinemas</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }

    .container {
      width: 80%;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      color: #333;
    }

    .movie-details {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
    }

    .movie-poster img {
      width: 300px;
      height: 100%;
      border-radius: 8px;
    }

    .movie-info {
      width: 60%;
    }

    .movie-info h2 {
      font-size: 30px;
      color: #333;
    }

    .movie-info p {
      font-size: 16px;
      line-height: 1.6;
      color: #555;
    }

    .showtimes {
      margin-top: 20px;
    }

    .showtimes h3 {
      font-size: 20px;
      color: #333;
    }

    .showtimes ul {
      list-style-type: none;
      padding-left: 0;
    }

    .showtimes li {
      font-size: 16px;
      color: #007BFF;
      margin: 5px 0;
    }

    button {
      padding: 12px 20px;
      background-color: #008cba;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 20px;
    }

    button:hover {
      background-color: #005f6b;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Chi Tiết Phim</h1>

    <!-- Chi tiết phim Cô Dâu Hào Môn -->
    <div class="movie-details">
      <div class="movie-poster">
        <img src=<?php echo $chi_tiet_phim["link_img"] ?> alt="Cô Dâu Hào Môn">
      </div>
      <div class="movie-info">
        <h2><?php echo $chi_tiet_phim["ten"] ?></h2>
        <p><strong>Thể loại:</strong> <?php echo $chi_tiet_phim["the_loai"] ?> </p>
        <p><strong>Thời gian:</strong> <?php echo $chi_tiet_phim["thoi_luong"] ?></p>
        <p><strong>Mô tả:</strong><?php echo $chi_tiet_phim["mo_ta"] ?></p>
        <p><strong>Ngôn ngữ:</strong><?php echo $chi_tiet_phim["ngon_ngu"] ?></p>

        <!-- Lịch chiếu và đặt vé -->
        <div class="showtimes">
          <h3>Lịch Chiếu</h3>
          <ul>
            <li>12:00 PM - Rạp 1</li>
            <li>03:00 PM - Rạp 2</li>
            <li>06:00 PM - Rạp 3</li>
            <li>08:00 PM - Rạp 1</li>
          </ul>
        </div>
        <button id="book-ticket-btn" onclick="goToBooking()">Đặt vé</button>
      </div>
    </div>
  </div>

  <script src="script.js"></script>
</body>

</html>