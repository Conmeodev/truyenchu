<?php
ob_start(); // Bắt đầu bộ đệm đầu ra
session_start();
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if(isset($_SESSION['id_admin'])) {
    // Nếu đã đăng nhập, lấy thông tin người dùng từ session
    $ten_nguoidung = $_SESSION['ten'];

    // Hiển thị thông tin người dùng và liên kết đăng xuất
    echo "<nav class='navbar navbar-expand-lg navbar-light bg-light'>
            <span class='navbar-brand mb-0 h1'>Xin chào: $ten_nguoidung</span>
            <div class='navbar-collapse justify-content-end'>
                <a class='nav-link' href='?action=dangxuat'>Đăng xuất</a>
            </div>
          </nav>";

    // Xử lý đăng xuất nếu được yêu cầu
    if (isset($_GET['action']) && $_GET['action'] == 'dangxuat') {
        // Hủy bỏ toàn bộ session
        session_destroy();

        // Chuyển hướng về trang chính sau khi đăng xuất
        header("Location: ../index.php");
        exit();
    }
} else {
    // Nếu chưa đăng nhập, hiển thị nút đăng nhập và đăng ký
    echo "<nav class='navbar navbar-expand-lg navbar-light bg-light'>
            <div class='navbar-collapse justify-content-end'>
                <a class='nav-link' href='index.php?action=dangnhap&query=dangnhap'>Đăng nhập</a>
            </div>
          </nav>";
}
?>
