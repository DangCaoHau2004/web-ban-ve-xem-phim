<?php

include('navbar.php');

// session để lưu thông báo lỗi
if (isset($_SESSION['thong_bao'])) {
    $error = $_SESSION['thong_bao'];  // biến error lưu session thông báo
    unset($_SESSION['thong_bao']); // xóa biến session
} else {
    $error = "";
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE email = '$email' AND mat_khau = '$password'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['id'];
        // Thêm đoạn mã này để lưu thông tin người dùng vào session
        $_SESSION['users'] = [
            'ho_ten' => $row['ho_ten'],
            'ngay_sinh' => $row['ngay_sinh'],
            'gioi_tinh' => $row['gioi_tinh'],
            'sdt' => $row['sdt'],
            'email' => $row['email']
        ];
        header("Location: index.php"); // Chuyển hướng về trang chủ nếu thành công
        exit();
    } else {
        // Nếu đăng nhập khi ghi sai mật khẩu và email
        $_SESSION['thong_bao'] = "Sai email hoặc mật khẩu | Incorrect email or password"; // lưu thông báo vào session
        header("Location: " . $_SERVER['PHP_SELF']); // Chuyển hướng lại trang hiện tại
        exit();
    }
}
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body {
            padding: 0;
            margin: 0;
            background-color: #f8f8f8;
        }

        html {

            font-family: 'Source Sans Pro', sans-serif;
        }

        .pre-header {
            width: 100%;
            height: 23px;

        }

        .header {
            width: 100%;
            height: 75px;

        }

        /* code login */

        .form-group {
            margin-top: 14px;
            margin-right: 20px;
            margin-bottom: 20px;


        }

        label {
            font-size: 18px;
            color: #3333;
        }

        .input-icon {
            margin-bottom: 10px;
            position: relative;
            padding-right: 23px;

        }

        .input-icon i {
            position: absolute;
            color: #ccc;
            margin: 15px 2px 4px 10px;
            font-size: 15px;

        }

        ::placeholder {
            color: #ccc;


        }


        .forgot-password {

            color: #337ab7;
            font-size: 16px;
            text-decoration: none;

        }

        .forgot-password:hover {
            text-decoration: underline;

        }

        .container {
            margin-top: 58px;
            margin-bottom: 20px;
            margin-left: auto;
            margin-right: auto;
            width: 530px;
            height: 423px;
        }



        .tabs div {

            text-align: center;
            padding: 17px;
            border-bottom: 1px solid gainsboro;
            font-size: 16px;
            background-color: blue;
            color: white;
            font-weight: bold;

        }


        .tab-container {
            padding: 16px;
            background-color: #ffffff;
            box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.1);
        }



        label {

            color: #555;
        }

        #email-form,
        #email-form-2,
        #password {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 2px;
            width: 100%;
            padding-left: 33px;
            font-size: 16px;
        }

        .btn {
            font-size: 14px;
            margin-top: 15px;
            margin-bottom: 15px;

            padding: 10px 40px;
            background: linear-gradient(90deg, red, rgb(255, 127, 127));
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;


        }

        .login-button {
            text-align: center;

        }

        .btn:hover {
            background: linear-gradient(90deg, rgb(255, 210, 127), orange);
            color: black;
            transition: 0.5s;
        }

        .forget-password-modal {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.7);

            display: none;
            animation: fadeIn ease-in 0.2s;

        }


        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .forget-password-modal.open {
            display: flex;
        }

        .modal-container {
            background-color: #fff;
            width: 535px;
            min-height: 200px;
            position: relative;
            margin: auto;

        }

        .modal-header {

            padding-left: 15px;
            font-size: 23px;
            height: 60px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #e5e5e5;
        }

        .modal-close {
            position: absolute;
            right: 0;
            top: 0;
            padding: 12px;
            cursor: pointer;
            opacity: 0.7;
            font-size: 20px;
        }

        .modal-close:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 10px 20px;
        }

        .forgot-password {
            cursor: pointer;
        }

        .get-password-button {
            font-size: 14px;

            margin-top: 15px;
            margin-bottom: 15px;

            padding: 10px 40px;

            background-color: rgb(34, 136, 202);
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            opacity: 1;

        }

        .get-password-button:hover {
            opacity: 0.8;

            color: #fff;
        }

        .forget-password-button {

            text-align: center;
        }

        .error {
            color: red;

            font-weight: 450;
            font-size: 14px;
        }

        .footer {
            width: 100%;
            height: 659px;

        }
    </style>
</head>

<body>
    <div class="container">
        <div class="tabs">
            <div id="login-tab">ĐĂNG NHẬP</div>
        </div>
        <div class="tab-container">
            <form name="form1" method="POST" onsubmit=" return validation()">

                <p style="color: red;"><?php echo $error; ?></p>


                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <input type="email" id="email-form" name="email" placeholder="Email">
                    </div>

                </div>

                <div class="form-group"><label for="password">Mật khẩu</label>
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Mật khẩu">
                    </div>

                </div>

                <!-- <div class="form-group ">
                    <span href="#" class="forgot-password js-buy-ticket">Quên mật khẩu?</span>
                </div> -->

                <div class="login-button"><button type="submit" name="login" class="btn">ĐĂNG NHẬP BẰNG TÀI KHOẢN</button>
                </div>
            </form>
        </div>

    </div>
    <?php
    include("foot.php");
    ?>

    <div class="forget-password-modal js-modal">

        <div class="modal-container js-modal-container">
            <div class="modal-close js-modal-close">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <div class="modal-header">
                LẤY LẠI MẬT KHẨU
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <input type="email" id="email-form-2" name="email" placeholder="Email">
                    </div>

                </div>
                <div class="forget-password-button">
                    <button class="get-password-button">LẤY LẠI MẬT KHẨU</button>
                </div>

            </div>
        </div>


    </div>
    <script>
        //javascript modal hiện lên quên mật khẩu
        const forgetPW = document.querySelector('.js-buy-ticket')
        const modal = document.querySelector('.js-modal')
        const modalContainer = document.querySelector('.js-modal-container')
        const modalClose = document.querySelector('.js-modal-close')

        // thực hiện đóng mở modal
        function showForgetPassword() {
            modal.classList.add('open')
        }

        function hideBuyTicket() {
            modal.classList.remove('open')
        }
        //lắng nghe sự kiện click
        forgetPW.addEventListener('click', showForgetPassword)
        modalClose.addEventListener('click', hideBuyTicket)
        modal.addEventListener('click', hideBuyTicket)
        modalContainer.addEventListener('click', function(event) {
            event.stopPropagation()
        })
        // xử lý form nhập đưa thông báo 
        function validation() {
            var mail = document.form1.email.value;
            var pass = document.form1.password.value;

            const regex = /^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/; // biến để xác thực email
            // kiểm tra email mật khẩu nếu bị trống
            if (mail.length == "" && pass.length == "") {
                alert("Vui lòng nhập email và mật khẩu");
                return false
            } else {
                if (mail.length == "") {
                    alert("Vui lòng nhập email");
                    return false
                }
                if (pass.length == "") {
                    alert("Vui lòng nhập mật khẩu");
                    return false
                }
            }
            if (!regex.test(mail)) {
                alert("Email nhập chưa đúng định dạng!")
                return false
            }

        }
    </script>
</body>

</html>