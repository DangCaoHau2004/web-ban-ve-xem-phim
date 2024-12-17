<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>

    <style>
        /* Style cho chân trang */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Style cho khung của chân trang */
        .frame_info {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            background-color: #f9f9f9;
            padding: 25px;
            font-size: 14px;
            border-top: 1px solid gray;
        }

        /* Style cho item của chân trang */
        .item_info {
            margin-right: 160px;
        }

        /* Style cho logo */
        .logo {
            width: 150px;
            padding: 20px 0px 0px;
            padding-left: 75%;
        }

        /* Style cho tiêu đề */
        .item_info h3 {
            font-size: 20px;
            border-bottom: 4.5px solid #0056b3;
            padding-bottom: 5px;
        }

        /* Style cho item "Cụm rạp" */
        .beta {
            width: 400px;
            padding-left: 11%;
        }

        .beta h3 {
            width: 95px;
        }

        .item_info ul {
            list-style: none;
            padding: 0;
        }

        .item_info ul li {
            margin-bottom: 10px;
            cursor: pointer;
        }

        /* Style cho item "Liên hệ */
        .contact {
            width: 225px;
        }

        .contact h3 {
            width: 80px;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <!-- Footer -->
    <div class="frame_info">
        <!-- Ảnh logo -->
        <div class="item_info">
            <a href="index.php"><img src="./img/logo.png" alt="Cinemas Logo" class="logo"></a>
        </div>

        <div class="item_info">
            <!-- Cụm rạp-->
            <div class="beta">
                <h3>CỤM RẠP</h3>
                <ul>
                    <li>
                        <span><i class="fa-solid fa-angle-right"></i></span>
                        <span class="address">Cinemas Giải Phóng, Hà Nội - Hotline 0585 680 360</span>
                    </li>
                    <li>
                        <span><i class="fa-solid fa-angle-right"></i></span>
                        <span class="address">Cinemas Thanh Xuân, Hà Nội - Hotline 082 4812878</span>
                    </li>
                    <li>
                        <span><i class="fa-solid fa-angle-right"></i></span>
                        <span class="address">Cinemas Mỹ Đình, Hà Nội - Hotline 0866 154 610</span>
                    </li>
                    <li>
                        <span><i class="fa-solid fa-angle-right"></i></span>
                        <span class="address">Cinemas Đan Phượng, Hà Nội - Hotline 0983 901 714</span>
                    </li>
                    <li>
                        <span><i class="fa-solid fa-angle-right"></i></span>
                        <span class="address">Tải Ứng Dụng Cinemas</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="item_info">
            <!-- Liên hệ -->
            <div class="contact">
                <h3>LIÊN HỆ</h3>
                <p><strong>CÔNG TY CỔ PHẦN MEDIA</strong></p>
                <p>Giấy chứng nhận ĐKKD số: 0106633482 - Đăng ký lần đầu ngày 13/08/2024 tại Sở Kế hoạch và Đầu tư Thành phố Hà Nội</p>
                <p>Địa chỉ trụ sở: Số 18, phố Viên, phường Đức Thắng, quận Bắc Từ Liêm, thành phố Hà Nội</p>
                <p>Hotline: 1900 636807 / 0934632682</p>
                <p>Email: abc@cinemas.vn</p>
                <h4>Liên hệ hợp tác kinh doanh:</h4>
                <p>Hotline: 1800 646 420</p>
                <p>Email: abc@group.vn</p>
            </div>
        </div>
    </div>
</body>

</html>