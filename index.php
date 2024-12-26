<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body {
            padding: 0;
            margin: 0;
        }

        .slide-container {
            position: relative;
            width: 100%;
            height: 585px;
        }

        .slide-container .slides {
            width: 100%;
            height: 100%;

            position: relative;
            overflow: hidden;
        }

        .slide-container .slides img {
            width: 100%;
            height: 100%;
            position: absolute;
            object-fit: cover;
        }

        /* css cho slide không được active(slide chưa được hiển thị) */
        /* để ẩn các ảnh chưa được hiển thị trong slide */
        .slide-container .slides img:not(.active) {
            top: 0;
            left: -100%;
        }



        span.next,
        span.prev {
            position: absolute;
            top: 50%;

            transform: translateY(-50%);
            padding: 5px;
            color: #6F7A7C;
            font-size: 50px;
            font-weight: bold;

            transition: 0.5s;
            border-radius: 3px;
            user-select: none;
            cursor: pointer;
            z-index: 1;
        }


        span.next {
            right: 20px;
        }

        span.prev {
            left: 20px;
        }

        span.next:hover,
        span.prev:hover {

            background-color: #ede6d6;
            opacity: 0.6;

        }

        .dotsContainer {
            position: absolute;
            bottom: 20px;
            z-index: 3;
            left: 50%;
            transform: translateX(-50%);
        }

        .dotsContainer .dot {
            width: 15px;
            height: 15px;
            margin: 0px 2px;
            border: 3px solid #bbb;
            border-radius: 50%;
            display: inline-block;
            cursor: pointer;
            transition: background-color 0.6s ease;
        }

        .dotsContainer .active {
            background-color: #999;
        }

        /* hiệu ứng chuyển ảnh */
        /* khi ảnh được bấm nút next và auto slide next  */
        /* Đẩy hình hiện tại sang trái */
        @keyframes next1 {
            from {
                /* từ vị trí đầu (ở giữa màn hình) */
                left: 0%;
            }

            to {
                /* di chuyển ra khỏi màn hình sang bên trái  */
                left: -100%;
            }
        }


        /* Kéo hình tiếp theo vào từ phải vào thay thế next 1 */
        @keyframes next2 {
            from {
                /* ảnh từ  bên phải  */
                left: 100%
            }

            to {
                /* di chuyển vào màn hình và dừng lại ở giữa màn hình */
                left: 0%;
            }
        }

        /* khi ảnh được bấm nút prev và auto slide prev */
        /* Đẩy hình hiện tại sang phải */
        @keyframes prev1 {
            from {
                /* ảnh ở giữa màn hình */
                left: 0%
            }

            to {
                /* ảnh rời khỏi khung hình sang bên phải */
                left: 100%;
            }
        }

        /* Kéo hình tiếp theo vào từ trái */
        @keyframes prev2 {
            from {
                /* ảnh ở bên trái ngoài khung hình */
                left: -100%
            }

            to {
                /* ảnh ở bên trái di chuyển  vào giữa màn hình */
                left: 0%;
            }
        }
    </style>
</head>

<body>
    <!-- navbar -->
    <?php
    include("navbar.php");
    ?>
    <!-- main -->
    <div class="main">
        <!-- slide -->
        <div class="slide-container">
            <div class="slides">
                <?php
                $sql = "SELECT img_background FROM phim LIMIT 5";
                $result = mysqli_query($conn, $sql);
                $addActive = false; //biến gán class active cho ảnh đầu tiên
                while ($row = $result->fetch_assoc()) {
                    $imgSrc = $row["img_background"];
                    echo '<img src="' . $imgSrc . '" ' . (!$addActive ? 'class="active"' : '') . '>'; //ktra addactive false để gắn class active cho ảnh đầu
                    $addActive = true; // gắn addactive lại true để tất cả ảnh sau (ko phải ảnh đầu) ko có class active
                }

                ?>
            </div>

            <div class="buttons">
                <span class="next"><i class="fa-solid fa-angle-right"></i></span>
                <span class="prev"><i class="fa-solid fa-angle-left"></i></span>
            </div>

            <div class="dotsContainer">
                <div class="dot active" attr='0' onclick="switchImage(this)"></div> <!-- chấm 1 -->
                <div class="dot" attr='1' onclick="switchImage(this)"></div> <!-- Chấm 2 -->
                <div class="dot" attr='2' onclick="switchImage(this)"></div> <!-- Chấm 3 -->
                <div class="dot" attr='3' onclick="switchImage(this)"></div> <!-- Chấm 4 -->
                <div class="dot" attr='4' onclick="switchImage(this)"></div> <!-- Chấm 5 -->
            </div>

        </div>


    </div>
    <!-- footer -->
    <?php
    include("foot.php");
    ?>
    <script>
        let slideImages = document.querySelectorAll('.slides img'); // trỏ vào img của slide
        let next = document.querySelector('.next'); // nút điều khiển bên phải
        let prev = document.querySelector('.prev'); // nút điều khiển bên trái
        let dots = document.querySelectorAll('.dot'); // nút chấm dưới slide

        let counter = 0; //biến đếm lưu slide hiện tại
        let autoSlideInterval; // biến lưu trạng thái tự động chuyển slide

        // Hàm tự động chuyển slide sau 3,5 giây
        function autoSliding() {
            autoSlideInterval = setInterval(slideNext, 3500); // thiết lập chuyển slide tiếp mỗi 3,5 giây
        }

        // Hàm dừng tự động chuyển slide
        function stopSliding() {
            clearInterval(autoSlideInterval); // clearInterval :dừng biến autoslide 
        }

        // Hàm khởi động lại tự động chuyển slide
        function restartSliding() {
            stopSliding();
            autoSliding();
        }

        // Hàm xử lý lắng nghe click nút Next (nút bên phải)
        next.addEventListener('click', () => {
            stopSliding();
            slideNext();
            restartSliding();
        });
        // hàm chuyển slide tiếp từ phải sang trái 
        function slideNext() {
            slideImages[counter].style.animation = 'next1 0.5s ease-in forwards'; // thêm animation
            if (counter >= slideImages.length - 1) {
                counter = 0;
            } else {
                counter++;
            }
            slideImages[counter].style.animation = 'next2 0.5s ease-in forwards';

            indicators(); // gọi để cập nhật nút chấm dots
        }

        //Hàm xử lý lắng nghe click nút prev (nút bên trái)
        prev.addEventListener('click', () => {
            stopSliding();
            slidePrev();
            restartSliding();
        });
        // hàm chuyển slide tiếp từ trái sang phải
        function slidePrev() {
            slideImages[counter].style.animation = 'prev1 0.5s ease-in forwards';
            if (counter == 0) {
                counter = slideImages.length - 1;
            } else {
                counter--;
            }
            slideImages[counter].style.animation = 'prev2 0.5s ease-in forwards';
            indicators();
        }

        // hàm Thêm và xóa lớp 'active' từ các chấm (dots)
        function indicators() {
            for (let i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(' active', ''); // Loại bỏ lớp 'active' khỏi chấm
            }
            dots[counter].className += ' active'; // Thêm lớp 'active' cho chấm tương ứng với slide hiện tại
        }

        // Hàm xử lý khi người dùng nhấn vào nút chấm dưới ảnh
        function switchImage(currentImage) {
            stopSliding();
            let imageId = parseInt(currentImage.getAttribute('attr')); //  lấy attribute của trong dot
            if (imageId > counter) { //nếu bấm nút chấm không đúng với slide hiện tại thì di chuyển slide vào đúng nút chấm đấy
                slideImages[counter].style.animation = 'next1 0.5s ease-in forwards';
                counter = imageId; // cập nhật slide hiện tại đúng với chấm được bấm vào
                slideImages[counter].style.animation = 'next2 0.5s ease-in forwards';
            } else if (imageId == counter) { // nếu nút chấm hiện tại đang ở đúng với slide của nút thì không làm gì
                return
            } else { //nếu bấm nút chấm không đúng với slide hiện tại  thì di chuyển slide vào đúng nút chấm đấy
                slideImages[counter].style.animation = 'prev1 0.5s ease-in forwards';
                counter = imageId; // cập nhật slide hiện tại đúng với chấm được bấm vào
                slideImages[counter].style.animation = 'prev2 0.5s ease-in forwards';

            }

            indicators(); // Cập nhật nút chấm dots
            restartSliding();
        }

        // Gọi hàm autoSliding 
        autoSliding();
    </script>
</body>

</html>
<?php
$conn->close();
?>