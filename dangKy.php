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
            VALUES ('$ho_ten', '$email', '$mat_khau', '$ngay_sinh', '$gioi_tinh', '$sdt')";
            if ($conn->query($sql) === true) {
                echo'<script>alert("Bạn đã đăng ký thành công!");</script>';
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

    <style>
        /* Style cho tab Đăng ký */
        body {
            margin: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            display: block;
            height: 100%;
            background-color: #f7f7f7;
        }

        /* Loại bỏ gach chân đường link */
        a {
            text-decoration: none;
        }

        /* Style cho khung 2 nút đăng nhập - đăng ký */
        .login_sign-up {
            display: block;
            justify-self: center;
            padding-top: 50px;
        }

        .button_sign-up {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 540px;
            height: 50px;
            font-size: 16px;
            border: none;
            background-color: blue;
            color: white;
            font-weight: bold;
        }

        /* Style cho khung form đăng ký */
        .frame_signup {
            background-color: #fff;
            padding: 20px;
            width: 500px;
            max-width: 100%;
            justify-self: center;
        }

        /* Chia cột cho from */
        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;

        }

        /* Style cho từng item */
        .item_signup {
            display: flex;
            flex-direction: column;
        }

        .in_signup {
            font-size: 14.5px;
            color: #333;
            margin-bottom: 5px;
        }

        /* Style cho dấu sao bắt buộc */
        .force {
            color: red;
        }

        /* Style cho phần nhập thông tin */
        .frame_input {
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .icon {
            color: #aaa;
            padding-left: 10px;
        }

        .name, .email, .password, .confirm-password, .dob, .phone {
            padding: 10px;
            font-size: 14.5px;
            border: none;
        }

        .name {
            width: 218.5px;
        }

        .email, .password, .confirm-password, .dob, .phone {
            width: 187.5px;
        }

        input::placeholder {
            color: #aaa;
        }

        input:focus {
            outline: none;
        }

        select {
            padding: 10px;
            font-size: 14.5px;
            border: none;
            color: #666;
            width: 213.5px;
        }

        /* Style cho nút Đăng ký */
        .join {
            margin: 15px 0px;
            grid-column: span 2;
        }

        .allow_signup {
            text-align: center;
            font-size: 14.5px;
            color: white;
            background: linear-gradient(90deg, red, rgb(255, 127, 127));
            border: none;
            border-radius: 5px;
            padding: 12.5px 35px;
            display: block;
            margin: auto;
        }

        /* Style cho nút Đăng ký khi trỏ chuột */
        .allow_signup:hover {
            background: linear-gradient(90deg, rgb(255, 210, 127), orange);
            color: black;
            transition: 0.5s;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
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
                    <span class="icon"><i class="fa-solid fa-envelope"></i></span>
                    <span><input type="email" name="email" id="email" placeholder="Email" class="email" required></span>
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
            </div>
        </form>
    </div>
</body>
</html>