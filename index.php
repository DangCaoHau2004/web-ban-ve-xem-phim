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
            height: 510px;

            /* box-shadow: 0 0 8px 2px rgba(0, 0, 0, 0.2); */
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

        @keyframes next1 {
            from {
                left: 0%
            }

            to {
                left: -100%;
            }
        }

        @keyframes next2 {
            from {
                left: 100%
            }

            to {
                left: 0%;
            }
        }

        @keyframes prev1 {
            from {
                left: 0%
            }

            to {
                left: 100%;
            }
        }

        @keyframes prev2 {
            from {
                left: -100%
            }

            to {
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
                <img src="./img/1702x621-23-114246-141124-41.jpg" class="active">
                <img src="./img/1702x621-24-162735-201124-55.jpg">
                <img src="./img/980wx448h_20_.jpg">
                <img src="./img/z5959426229506-c7d3539d88024f520ccb323596167a36-145928-231024-88.jpg">
                <img src="./img/gladiator-2048_1730878996598.jpg">
            </div>

            <div class="buttons">
                <span class="next"><i class="fa-solid fa-angle-right"></i></span>
                <span class="prev"><i class="fa-solid fa-angle-left"></i></span>
            </div>

            <div class="dotsContainer">
                <div class="dot active" attr='0' onclick="switchImage(this)"></div>
                <div class="dot" attr='1' onclick="switchImage(this)"></div>
                <div class="dot" attr='2' onclick="switchImage(this)"></div>
                <div class="dot" attr='3' onclick="switchImage(this)"></div>
                <div class="dot" attr='4' onclick="switchImage(this)"></div>
            </div>
            <div class="film"></div>
        </div>
        <script>
            let slideImages = document.querySelectorAll('img');
            // Access the next and prev buttons
            let next = document.querySelector('.next');
            let prev = document.querySelector('.prev');
            // Access the indicators
            let dots = document.querySelectorAll('.dot');

            var counter = 0;

            // Code for next button
            next.addEventListener('click', slideNext);

            function slideNext() {
                slideImages[counter].style.animation = 'next1 0.5s ease-in forwards';
                if (counter >= slideImages.length - 1) {
                    counter = 0;
                } else {
                    counter++;
                }
                slideImages[counter].style.animation = 'next2 0.5s ease-in forwards';
                indicators();
            }

            // Code for prev button
            prev.addEventListener('click', slidePrev);

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

            // Auto slideing
            function autoSliding() {
                deletInterval = setInterval(timer, 3500);

                function timer() {
                    slideNext();
                    indicators();
                }
            }
            autoSliding();



            // Add and remove active class from the indicators
            function indicators() {
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(' active', '');
                }
                dots[counter].className += ' active';
            }

            // Add click event to the indicator
            function switchImage(currentImage) {
                currentImage.classList.add('active');
                var imageId = currentImage.getAttribute('attr');
                if (imageId > counter) {
                    slideImages[counter].style.animation = 'next1 0.5s ease-in forwards';
                    counter = imageId;
                    slideImages[counter].style.animation = 'next2 0.5s ease-in forwards';
                } else if (imageId == counter) {
                    return;
                } else {
                    slideImages[counter].style.animation = 'prev1 0.5s ease-in forwards';
                    counter = imageId;
                    slideImages[counter].style.animation = 'prev2 0.5s ease-in forwards';
                }
                indicators();
            }
        </script>
    </div>
    <!-- footer -->
    <?php
    include("foot.php");
    ?>

</body>

</html>