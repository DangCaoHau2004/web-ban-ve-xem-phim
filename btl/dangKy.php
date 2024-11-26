<?php
    //Liên kết với CSDL
    include("database.php");
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $ho_ten = $_POST['ho_ten'];
        $email = $_POST['email'];
        $mat_khau = $_POST['mat_khau'];
        $reup_mat_khau = $_POST['reup_mat_khau'];
        $ngay_sinh = $_POST['ngay_sinh'];
        $gioi_tinh = $_POST['gioi_tinh'];
        $sdt = $_POST['sdt'];
        $mat_khau_hash = password_hash($mat_khau,PASSWORD_DEFAULT);
    
        // Kiểm tra email có tồn tại trong CSDL không
        $check_email = "SELECT * FROM users WHERE email = ?";
        $ktra = $conn->prepare($check_email); //gửi câu lệnh SQL đến CSDL để kiểm tra cú pháp trước khi thực thi
        $ktra->bind_param("s", $email); //(s: kiểu string), gắn (bind) tham số $email vào vị trí ? trong câu lệnh SQL
        $ktra->execute(); //gửi câu lệnh SQL với giá trị thực tế đến CSDL để thực hiện truy vấn. Nếu thành công, câu lệnh sẽ trả về kết quả.
        $result = $ktra->get_result(); //Lấy kết quả của truy vấn SQL đã thực thi trước đó

        if ($result->num_rows > 0) {
            echo'<script>alert("Email này đã được sử dụng. Vui lòng thử email khác!");</script>';
        }
        // Kiểm tra sự trùng khớp của mật khẩu
        elseif($mat_khau !== $reup_mat_khau) {
            echo'<script>alert("Mật khẩu bạn nhập không khớp. Vui lòng xem lại!");</script>';
        } else {
            // Thêm dữ liệu vào bảng
            $sql = "INSERT INTO users (ho_ten, email, mat_khau, ngay_sinh, gioi_tinh, sdt) 
            VALUES ('$ho_ten', '$email', '$mat_khau_hash', '$ngay_sinh', '$gioi_tinh', '$sdt')";
            if ($conn->query($sql) === true) {
                $_SESSION['ho_ten'] = $ho_ten;
                $_SESSION['users'] = ['ho_ten' => $ho_ten, 
                                    'email' => $email, 
                                    'ngay_sinh' => $ngay_sinh, 
                                    'gioi_tinh' => $gioi_tinh, 
                                    'sdt' => $sdt ]; 
                // Lưu thông tin người dùng vào phiên làm việc
                echo '<script> alert("Bạn đã đăng ký thành công!"); window.location.href = "main_after.php"; </script>';
                exit();
            } else {
                echo '<script>alert("Lỗi: ");</script>' . $conn->error;
            }
            $conn->close();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="./dangKy.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <?php
        include("navbar.php");
    ?>
    <!-- Tab Đăng ký -->
    <div class="login_sign-up">
        <div class="button_sign-up">ĐĂNG KÝ</div>
    </div>

    <!-- Form đăng ký -->
    <div class="frame_signup">
        <form ID="signup" action="dangKy.php" method="POST">
            <!-- Họ tên -->
            <div class="item_signup">
                <div class="in_signup">
                    <span class="force">*</span>
                    <span>Họ tên</span>
                </div>
                <div class="frame_input">
                    <span><input type="text" name="ho_ten" id="name" placeholder="Họ tên" class="name" required></span>
                </div>
            </div>

            <!-- Email -->
            <div class="item_signup">
                <div class="in_signup">
                    <span class="force">*</span>
                    <span>Email</span>
                </div>
                <div class="frame_input">
                    <p class="icon"><i class="fa-solid fa-envelope"></i></p>
                    <span><input style="height:20px;" type="email" name="email" id="email" placeholder="Email" class="email" required></span>
                </div>
            </div>

            <!-- Mật khẩu -->
            <div class="item_signup">
                <div class="in_signup">
                    <span class="force">*</span>
                    <span>Mật khẩu</span>
                </div>
                <div class="frame_input">
                    <span class="icon"><i class="fa-solid fa-lock"></i></span>
                    <span><input type="password" name="mat_khau" id="password" placeholder="Mật khẩu" class="password" required></span>
                </div>
            </div>

            <!-- Xác nhận lại mật khẩu -->
            <div class="item_signup">
                <div class="in_signup">
                    <span class="force">*</span>
                    <span>Xác nhận lại mật khẩu</span>
                </div>
                <div class="frame_input">
                    <span class="icon"><i class="fa-solid fa-lock"></i></span>
                    <span><input type="password" name="reup_mat_khau" id="confirm-password" placeholder="Xác nhận lại mật khẩu" class="confirm-password" required></span>
                </div>
            </div>

            <!-- Ngày sinh -->
            <div class="item_signup">
                <div class="in_signup">
                    <span class="force">*</span>
                    <span>Ngày sinh</span>
                </div>
                <div class="frame_input">
                    <span class="icon"><i class="fa-regular fa-calendar-days"></i></span>
                    <span><input type="date" name="ngay_sinh" id="dob" class="dob" required></span>
                </div>
            </div>

            <!-- Giới tính -->
            <div class="item_signup">
                <div class="in_signup">
                    <span class="force">*</span>
                    <span>Giới tính</span>
                </div>
                <div class="frame_input">
                    <span class="icon"><i class="fa-solid fa-person"></i></span>
                    <span>
                        <select name="gioi_tinh" id="gender" placeholder="Giới tính" required>
                            <option value="">Giới tính</option>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                            <option value="Khác">Khác</option>
                        </select>
                    </span>
                </div>
            </div>

            <!-- Số điện thoại -->
            <div class="item_signup">
                <div class="in_signup">
                    <span class="force">*</span>
                    <span>Số điện thoại</span>
                </div>
                <div class="frame_input">
                    <span class="icon"><i class="fa-solid fa-square-phone"></i></span>
                    <span><input type="tel" name="sdt" id="phone" placeholder="Số điện thoại" class="phone" required></span>
                </div>
            </div>

            <!-- Nút "Đăng ký" -->
            <div class="join">
                <input type="submit" id="signup" value="ĐĂNG KÝ" class="allow_signup">
                <?php
                    
                ?>
            </div>
        </form>
    </div>
</body>
</html>