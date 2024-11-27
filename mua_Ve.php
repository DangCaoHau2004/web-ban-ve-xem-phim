<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Mua Vé - Beat Cinemas</title>
    <link rel="stylesheet" href="./styte.css">
    <style>body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
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
    
    .movie-selection, .time-selection, .seat-selection, .payment {
        margin-bottom: 20px;
    }
    
    button {
        padding: 10px 20px;
        cursor: pointer;
        margin: 5px;
    }
    
    button.seat {
        background-color: #f1f1f1;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    
    button.seat.selected {
        background-color: #4CAF50;
        color: white;
    }
    
    button.seat:disabled {
        background-color: #ddd;
        cursor: not-allowed;
    }
    
    .seats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }
    
    select {
        padding: 10px;
        width: 100%;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    
    .payment {
        text-align: center;
    }
    
    button#confirm-btn {
        background-color: #008cba;
        color: white;
        border: none;
        border-radius: 5px;
    }
    
    button#confirm-btn:hover {
        background-color: #005f6b;
    }</style>
</head>
<body>
    <div class="container">
        <h1>Mua Vé Xem Phim</h1>
        
        <div class="movie-selection">
            <h2>Chọn Phim</h2>
            <select id="movie-select">
                <option value="movie1">Phim 1: Avatar 2</option>
                <option value="movie2">Phim 2: Iron Man</option>
                <option value="movie3">Phim 3: Spider Man</option>
            </select>
        </div>
        
        <div class="ngay">
            <h2>Chọn Ngày</h2>
            <select id="ngay_select">
                <option value="ngay1">16/01/2025</option>
                <option value="ngay1">17/01/2025</option>
                <option value="ngay1">18/01/2025</option>
            </select>

        </div>

        <div class="time-selection">
            <h2>Chọn Giờ</h2>
            <select id="time-select">
                <option value="time1">12:00 PM</option>
                <option value="time2">03:00 PM</option>
                <option value="time3">06:00 PM</option>
            </select>
        </div>

        

        <div class="payment">
            <button id="confirm-btn">Chọn Ghế</button>
        </div>
    </div>

    <script src="./script.js"></script>
</body>
</html>