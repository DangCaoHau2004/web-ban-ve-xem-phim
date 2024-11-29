<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <!-- <link rel="stylesheet" href="information.css" /> -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #f9f9f9;
      font-family: Arial;
    }

    input[type="date"]::-webkit-inner-spin-button,
    input[type="date"]::-webkit-calendar-picker-indicator {
      display: none;
      -webkit-appearance: none;
    }

    .fa-circle-user {
      padding-top: 2px;
    }

    .info {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-top: 25px;
    }

    .info_text {
      margin-right: 970px;
      font-weight: bold;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      height: 40px;
      width: 210px;
      color: white;
      background-color: rgb(2, 84, 184);
    }

    .info_box {
      display: flex;
      background-color: white;
      width: 80%;
      height: 80vh;
    }

    .inside_box {
      margin: 20px;
    }

    .left p {
      font-size: 18px;
      margin-bottom: 10px;
    }

    .left i {
      color: gray;
      font-size: 19px;
      position: absolute;
      margin: 7px;
      margin-left: 8px;
    }

    .left input {
      padding-left: 35px;
    }

    .input {
      padding-left: 10px;
      font-size: 18px;
      height: 30px;
      width: 70vh;
    }

    .right {
      margin-left: 50px;
    }

    .right p {
      font-size: 18px;
      margin-bottom: 10px;
    }

    .right i {
      color: gray;
      font-size: 19px;
      position: absolute;
      margin: 9px;
    }

    .right input {
      padding-left: 35px;
    }

    #gender {
      padding-left: 30px;
      font-size: 18px;
      height: 31px;
      width: 75vh;
    }

    .change_pass {
      margin-top: 25px;
    }

    .change_pass a {
      text-decoration: none;
      color: blue;
      font-size: 18px;
    }

    .submit {
      display: flex;
      justify-content: center;
    }

    .submit input {
      font-size: 14px;
      color: white;
      background-color: #318ce7;
      border: none;
      border-radius: 5px;
      width: 150px;
      height: 40px;
    }
  </style>
</head>

<body>
  <?php
  include "navbar_after.php";
  // Connect to database
  // include("database.php");
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ho_ten = $_POST['ho_ten'];
    $ngay_sinh = $_POST['ngay_sinh'];
    $gioi_tinh = $_POST['gioi_tinh'];
    $sdt = $_POST['sdt'];

    // Update user information except email
    $sql = "UPDATE users SET ho_ten=?, ngay_sinh=?, gioi_tinh=?, sdt=? WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $ho_ten, $ngay_sinh, $gioi_tinh, $sdt, $_SESSION['users']['email']);

    if ($stmt->execute()) {
      $_SESSION['users']['ho_ten'] = $ho_ten;
      $_SESSION['users']['ngay_sinh'] = $ngay_sinh;
      $_SESSION['users']['gioi_tinh'] = $gioi_tinh;
      $_SESSION['users']['sdt'] = $sdt;
      echo '<script>alert("Cập nhật thành công!");</script>';
    } else {
      $_SESSION['ERR'] = "Lỗi đăng ký! Vui lòng thử lại sau!";
      header("Location: ERR404.php");
      exit(); //Kết thúc lệnh sau khi chuyển hướng
    }

    $stmt->close();
  }
  ?>
  <form action="information.php" method="post">
    <div class="info">
      <div class="info_text">
        <p>THÔNG TIN TÀI KHOẢN</p>
      </div>
      <div class="info_box">
        <div class="inside_box">
          <table>
            <tr>
              <td>
                <div class="left">
                  <p><span style="color: red">*</span> Họ tên</p>
                  <i class="fa-regular fa-circle-user"></i>
                  <input class="input" name="ho_ten" type="text" required value="<?php echo $_SESSION['users']['ho_ten']; ?>" />
                </div>
              </td>
              <td>
                <div class="right">
                  <p><span style="color: red">*</span> Email</p>
                  <i class="fa-solid fa-envelope"></i>
                  <input
                    class="input"
                    type="text"
                    readonly
                    placeholder="abc@gmail.com"
                    value="<?php echo $_SESSION['users']['email']; ?>" />
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <div class="left">
                  <p><span style="color: red">*</span> Ngày sinh</p>
                  <i class="fa-regular fa-calendar-days"></i>
                  <input class="input" name="ngay_sinh" type="date" required value="<?php echo $_SESSION['users']['ngay_sinh']; ?>" />
                </div>
              </td>
              <td>
                <div class="right">
                  <p><span style="color: red">*</span> Số điện thoại</p>
                  <i class="fa-solid fa-square-phone"></i>
                  <input
                    class="input"
                    type="tel"
                    required
                    name="sdt"
                    value="<?php echo $_SESSION['users']['sdt']; ?>" />
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <div class="left">
                  <p><span style="color: red">*</span> Giới tính</p>
                  <i class="fa-solid fa-person"></i>
                  <select name="gioi_tinh" id="gender" required>
                    <option value=""></option>
                    <option value="Nam" <?php echo $_SESSION['users']['gioi_tinh'] == 'Nam' ? 'selected' : ''; ?>>Nam</option>
                    <option value="Nữ" <?php echo $_SESSION['users']['gioi_tinh'] == 'Nữ' ? 'selected' : ''; ?>>Nữ</option>
                    <option value="Khác" <?php echo $_SESSION['users']['gioi_tinh'] == 'Khác' ? 'selected' : ''; ?>>Không rõ</option>
                  </select>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <div class="change_pass"><a href="">Đổi mật khẩu?</a></div>
              </td>
            </tr>
          </table>
          <div class="submit">
            <input type="submit" value="CẬP NHẬT" />
          </div>
        </div>
      </div>
    </div>
  </form>
</body>

</html>