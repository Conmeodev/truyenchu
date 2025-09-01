<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Hủy bỏ toàn bộ session
session_destroy();

// Chuyển hướng về trang chính sau khi đăng xuất
header("Location: index.php");
exit();


?>
