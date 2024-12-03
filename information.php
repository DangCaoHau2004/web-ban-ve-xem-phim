<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="information.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />
</head>
<body>
<?php
include "navbar_after.php";
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
      $_SESSION['ERR'] = "Lỗi cập nhật! Vui lòng thử lại sau!";
      header("Location: ERR404.php");
      exit(); // Kết thúc lệnh sau khi chuyển hướng
  }
  $stmt->close();
}

$conn->close();
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
      <input type="submit" value="CẬP NHẬT"> 
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
document.getElementById("passwordForm").onsubmit = function(event) {
  event.preventDefault();
  // alert("Password changed successfully!");
  modal.style.display = "none";
}
</script>
<?php
  include("foot.php");
?>