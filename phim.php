<?php
$id_phim = 1;
include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinemar - Danh Sách Phim</title>
    
    <style>
        /* Cấu trúc cơ bản */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

header {
    background-color: #333;
    color: white;
    padding: 20px;
    text-align: center;
}

header h1 {
    margin: 0;
}

nav ul {
    list-style-type: none;
    padding: 0;
}

nav ul li {
    display: inline;
    margin-right: 20px;
}

nav ul li a {
    color: white;
    text-decoration: none;
    font-size: 18px;
}

nav ul li a.active {
    text-decoration: underline;
}

#movie-list {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding: 20px;
    justify-content: center;
}

.movie-item {
    width: 200px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    padding: 10px;
    transition: transform 0.3s ease;
}

.movie-item img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-radius: 10px;
}

.movie-item h3 {
    font-size: 18px;
    margin: 10px 0;
}

.movie-item p {
    font-size: 14px;
    color: #777;
}

.movie-item:hover {
    transform: translateY(-10px);
}

.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

    </style>
</head>
<body>
    <header>
        <h1> Cinemar - Danh Sách Phim</h1>
        <nav>
            <ul>
                <li><a href="#" class="active" onclick="filterMovies('all')">Tất Cả</a></li>
                <li><a href="#" onclick="filterMovies('action')">Hành Động</a></li>
                <li><a href="#" onclick="filterMovies('comedy')">Hài Hước</a></li>
                <li><a href="#" onclick="filterMovies('drama')">Drama</a></li>
                <li><a href="#" onclick="filterMovies('horror')">Kinh Dị</a></li>
            </ul>
        </nav>
    </header>

    <section id="movie-list" class="movie-list">
        <!-- Danh sách phim sẽ được JavaScript điền vào đây -->
    </section>

    <div id="movie-detail-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="movie-title-detail"></h2>
            <img id="movie-img-detail" src="" alt="Phim Chi Tiết">
            <p id="movie-description-detail"></p>
            <p><strong>Thể loại:</strong> <span id="movie-genre-detail"></span></p>
            <p><strong>Đánh giá:</strong> <span id="movie-rating-detail"></span></p>
        </div>
    </div>
</body>
</html>
