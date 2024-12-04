<?php
session_start();
session_destroy(); // Hủy bỏ tất cả các session
header("Location: index.php"); // Chuyển hướng người dùng về trang navbar.php
exit(); // Kết thúc script
?>
