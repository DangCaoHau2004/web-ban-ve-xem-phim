<?php
session_start();
?>
<div style="width: 100%; text-align: center; height: 100vh;">
    <p style="font-size: 50px;">404 <?php echo isset($_SESSION['ERR']) ? $_SESSION['ERR'] : "Có lỗi xảy ra";
                                    unset($_SESSION['ERR']); ?></p>
    <a href="./index.php">Trở về trang chủ</a>
</div>