<?php
include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <?php if (isset($_SESSION['users']['ho_ten'])): ?>
          <a href="information.php">Xin chào: <?php echo $_SESSION['users']['ho_ten']; ?></a>
          <a href="logout.php"><i style="margin-left: 15px; margin-top:4px" class="fa-solid fa-right-from-bracket"></i></a>
        <?php else: ?>
          <a href="login.php">Đăng nhập</a>
          <a style="color: white">|</a>
          <a href="dangKy.php">Đăng ký</a>
        <?php endif; ?>
      </div>
    </div>
    <div class="nav_bar">
      <div class="nav_bar_logo">
        <a href="index.php"><img src="./img/logo.png" alt="logo" /></a>
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
