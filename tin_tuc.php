<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin Mới và Ưu Đãi | Beat Cinemas</title>
    <link rel="stylesheet" href="./style.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: white;
}

.container {
    width: 80%;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #333;
}

h2 {
    color: #007BFF;
    font-size: 25px;
    margin-bottom: 10px;
}

.news-section, .offers-section {
    margin-bottom: 40px;
}

.news-list, .offers-list {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.news-item, .offer-item {
    width: 80%;
    height: auto;
    background-color: #f9f9f9;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.news-item img, .offer-item img {
    width: 100%;
    height: 50%;
    border-radius: 8px;
    margin-bottom: 15px;
}

h3 {
    font-size: 18px;
    color: #333;
    margin-bottom: 10px;
}

p {
    font-size: 14px;
    color: #555;
    margin-bottom: 10px;
}

a {
    color: #007BFF;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .news-list, .offers-list {
        grid-template-columns: 1fr;
    }
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Tin Mới và Ưu Đãi</h1>

        <!-- Tab Tin Mới -->
        <div class="news-section">
            <h2>Tin Mới</h2>
            <div class="news-list">
                <div class="news-item">
                    <img src="./avatar.png" alt="Tin 1">
                    <h3>Phim Mới: Avatar 2 Sắp Chiếu Tại Beat Cinemas</h3>
                    <p>Avatar 2 sẽ chính thức ra mắt vào tháng 12 này. Đừng bỏ lỡ cơ hội thưởng thức bộ phim này với những công nghệ điện ảnh mới nhất tại Beat Cinemas!</p>
                    <a href="#">Đọc thêm</a>
                </div>
                <div class="news-item">
                    <img src="./love.png" alt="Tin 2">
                    <h3>Đưa Bạn Gái Đến Beat Cinemas Nhận Quà Lớn!</h3>
                    <p>Khuyến mãi đặc biệt dành cho các cặp đôi nhân dịp lễ tình nhân. Nhận ngay quà tặng đặc biệt khi đặt vé cùng người yêu tại Beat Cinemas.</p>
                    <a href="#">Đọc thêm</a>
                </div>
                <!-- Thêm tin tức khác ở đây -->
            </div>
        </div>

        <!-- Tab Ưu Đãi -->
        <div class="offers-section">
            <h2>Ưu Đãi</h2>
            <div class="offers-list">
                <div class="offer-item">
                    <h3>Giảm Giá 50% Vé Phim Cho Sinh Viên</h3>
                    <p>Sinh viên nhận ưu đãi giảm giá 50% khi xuất trình thẻ sinh viên tại quầy vé.</p>
                    <a href="#">Xem chi tiết</a>
                </div>
                <div class="offer-item">
                    <h3>Ưu Đãi Đặc Biệt Mùa Lễ: Mua 1 Tặng 1</h3>
                    <p>Mua một vé phim bất kỳ tại Beat Cinemas và nhận thêm một vé miễn phí cho bộ phim yêu thích!</p>
                    <a href="#">Xem chi tiết</a>
                </div>
                <!-- Thêm các ưu đãi khác ở đây -->
            </div>
        </div>
    </div>

    <script src="./script.js"></script>
</body>
</html>