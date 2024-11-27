<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>

    <style>
        /* Style cho tab Thông tin */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Style cho khung của tab Thông tin */
        .frame_info {
            margin: 50px;
            display: flex;
            justify-content: space-between;
            background-color: #f9f9f9;
            padding: 25px;
            font-size: 14px;
            border-top: 1px solid gray;
        }

        /* Style cho item của tab thông tin */
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

        /* Style cho item "Cụm rạp Beta" */
        .beta {
            width: 465px;
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

        /* Style cho địa chỉ "Cụm rạp beta" khi trỏ chuột */
        .address:hover {
            text-decoration: underline;
            color: #0056b3;
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
    <!-- Tab Thông tin -->
    <div class="frame_info">
        <!-- Ảnh logo -->
        <div class="item_info">
            <a href=""><img src="./img/logo.png" alt="Beta Cinemas Logo" class="logo"></a>
        </div>

        <div class="item_info">
            <!-- Cụm rạp Beta -->
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
                <p>Giấy chứng nhận ĐKKD số: 0106633482 - Đăng ký lần đầu ngày 08/09/2014 tại Sở Kế hoạch và Đầu tư Thành phố Hà Nội</p>
                <p>Địa chỉ trụ sở: Tầng 3, số 595, đường Giải Phóng, phường Giáp Bát, quận Hoàng Mai, thành phố Hà Nội</p>
                <p>Hotline: 1900 636807 / 0934632682</p>
                <p>Email: mkt@cinemas.vn</p>
                <h4>Liên hệ hợp tác kinh doanh:</h4>
                <p>Hotline: 1800 646 420</p>
                <p>Email: bachtx@group.vn</p>
            </div>
        </div>
    </div>
</body>

</html>