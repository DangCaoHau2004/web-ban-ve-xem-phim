<?php
include "navbar.php";
// include("database.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['ho_ten']) && isset($_POST['ngay_sinh']) && isset($_POST['gioi_tinh']) && isset($_POST['sdt']) && isset($_POST['email'])) {
    $ho_ten = $_POST['ho_ten'];
    $ngay_sinh = $_POST['ngay_sinh'];
    $gioi_tinh = $_POST['gioi_tinh'];
    $sdt = $_POST['sdt'];
    $email = $_POST['email'];

    // Update user information
    $sql = "UPDATE users SET ho_ten='$ho_ten', ngay_sinh='$ngay_sinh', gioi_tinh='$gioi_tinh', sdt='$sdt', email='$email' WHERE email='{$_SESSION['users']['email']}'";
    if (mysqli_query($conn, $sql)) {
      $_SESSION['users']['ho_ten'] = $ho_ten;
      $_SESSION['users']['ngay_sinh'] = $ngay_sinh;
      $_SESSION['users']['gioi_tinh'] = $gioi_tinh;
      $_SESSION['users']['sdt'] = $sdt;
      $_SESSION['users']['email'] = $email;
      echo '<script>alert("Cập nhật thông tin thành công!");</script>';
      header("Location: index.php");
      exit();
    } else {
      echo '<script>alert("Lỗi cập nhật! Vui lòng thử lại sau!");</script>';
      header("Location: index.php");
      exit();
    }
  }

  if (isset($_POST['currentPassword']) && isset($_POST['newPassword']) && isset($_POST['confirmPassword'])) {
    $op = $_POST['currentPassword'];
    $np = $_POST['newPassword'];
    $cnp = $_POST['confirmPassword'];
    $email = $_SESSION['users']['email'];

    if ($np == $cnp) {
      $query = "SELECT * FROM users WHERE email = '$email' AND mat_khau = '$op'";
      $result = mysqli_query($conn, $query);
      $count = mysqli_num_rows($result);
      if ($count > 0) {
        $query = "UPDATE users SET mat_khau = '$np' WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        if ($result) {
          echo '<script>alert("Mật khẩu cập nhật thành công!");</script>';
          header("Location: " . $_SERVER['PHP_SELF']);
          exit();
        } else {
          echo '<script>alert("Lỗi cập nhật mật khẩu! Vui lòng thử lại sau.");</script>';
          header("Location: " . $_SERVER['PHP_SELF']);
          exit();
        }
      } else {
        echo '<script>alert("Mật khẩu cũ không trùng khớp!");</script>';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
      }
    } else {
      echo '<script>alert("Mật khẩu mới không trùng với mật khẩu xác nhận!");</script>';
      header("Location: " . $_SERVER['PHP_SELF']);
      exit();
    }
  }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="information.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awaesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />
  <style>
    .input {
      height: 30px;
      width: 65vh;
    }

    #gender {
      margin-left: 25px;
      padding-left: 30px;
      font-size: 18px;
      height: 31px;
      width: 70vh;
    }

    .left input {
      padding-left: 35px;
      margin-left: 25px;
    }

    .left i {
      margin-left: 35px;
    }

    .left p {
      margin-left: 25px;
    }
  </style>
</head>
<body>
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
                    readonly
                    class="input"
                    type="text"
                    name="email"
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
<!-- Modal -->
<div id="passwordModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h2>ĐỔI MẬT KHẨU</h2><span class="close">&times;</span>
    </div>
    <hr>
    <form id="passwordForm" class="passwordForm" method="post" action="information.php">
      <div class="form-row">
        <label for="currentPassword">Mật khẩu hiện tại<span style="color: red">*</span></label>
        <input type="password" id="currentPassword" name="currentPassword" required placeholder="Nhập mật khẩu hiện tại">
      </div>
      <div class="form-row">
        <label for="newPassword">Mật khẩu mới<span style="color: red">*</span></label>
        <input type="password" id="newPassword" name="newPassword" required placeholder="Nhập mật khẩu mới">
      </div>
      <div class="form-row">
        <label for="confirmPassword">Xác nhận mật khẩu mới<span style="color: red">*</span></label>
        <input type="password" id="confirmPassword" name="confirmPassword" required placeholder="Nhập xác nhận mật khẩu mới">
      </div>
      <div class="submit-row">
        <input type="submit" value="CẬP NHẬT" name="update">
      </div>
    </form>
  </div>
</div>

</html>
<script>
  var modal = document.getElementById("passwordModal");
  var link = document.querySelector(".change_pass a");
  var span = document.getElementsByClassName("close")[0];

  // Click vào đổi mật khẩu
  link.onclick = function(event) {
    event.preventDefault(); // Tránh nó tự tắt
    modal.style.display = "block";
  }

  // Click vào dấu x để thoát
  span.onclick = function() {
    modal.style.display = "none";
  }

  // Click ra bên ngoài cũng sẽ thoát
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }

  // Cập nhật xong sẽ thoát khỏi giao diện quên mật khẩu
  // document.getElementById("passwordForm").onsubmit = function(event) {
  //   event.preventDefault();
  //   // alert("Password changed successfully!");
  //   modal.style.display = "none";
  // }
</script>
<?php
include("foot.php");
?>