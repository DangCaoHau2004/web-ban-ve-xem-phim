<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial;
      background-color: #f9f9f9;
    }

    .log_res {
      display: flex;
      background-color: black;
      height: 5vh;
      align-items: center;
      justify-content: right;
    }

    .margin_log_res {
      margin-right: 40px;
    }

    .log_res a {
      font-size: 15px;
      margin-right: 8px;
      color: white;
      text-decoration: none;
    }

    .nav_bar {
      display: flex;
      align-items: center;
      justify-content: left;
      background-color: white;
      height: 11vh;
    }

    .nav_bar_logo a {
      display: flex;
      height: 12vh;
      margin-left: 100px;
    }

    .movies a {
      color: black;
      font-size: 20px;
      text-decoration: none;
      display: flex;
      font-weight: bold;
      margin-left: 800px;
      margin-right: 30px;
    }

    .info_discounts a {
      color: black;
      font-size: 20px;
      text-decoration: none;
      display: flex;
      font-weight: bold;
    }
  </style>
</head>

<body>
  <div class="log_res">
    <div class="margin_log_res">
      <a href="login.php">Đăng nhập</a>
      <a style="color: white">|</a>
      <a href="dangKy.php">Đăng ký</a>
    </div>
  </div>
  <div class="nav_bar">
    <div class="nav_bar_logo">
      <a href="main.php"><img src="./img/logo.png" alt="logo" /></a>
    </div>
    <div class="movies">
      <a href="">PHIM</a>
    </div>
    <div class="info_discounts">
      <a href="">TIN MỚI VÀ ƯU ĐÃI</a>
    </div>
  </div>
</body>

</html>