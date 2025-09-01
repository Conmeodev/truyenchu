<?php
ob_start(); // Bắt đầu bộ đệm đầu ra
session_start();
// Kết nối đến cơ sở dữ liệu
include('./admin/config/config.php');

// Truy vấn CSDL để lấy danh sách thể loại
$query = "SELECT * FROM tbl_theloai";
$result = $mysqli->query($query);

// Tạo mảng để chứa dữ liệu thể loại
$theloaiArray = [];

// Kiểm tra và xử lý kết quả
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $theloaiArray[] = $row['tentheloai'];
    }
}

// Đóng kết nối
$mysqli->close();

// Bắt đầu session

?>
<div class="none">
    <div id="cf_path"><?php echo $getFolders ?? $inFiles['_byid']; ?></div>
</div>
<div class="nav-menu">
    <div class="nav-list">
        <span class="nav-sub btn" onclick="showcaidat();">📁</span>
        <a href="/" class="nav-sub btn">🏠 <?php echo $_SERVER['HTTP_HOST']; ?></a>
    </div>

</div>
<div id="caidat" class="none">
    <?php /*if (!isset($_SESSION['id_user'])): ?>
        <a class="menu disb" href="index.php?quanly=dangnhap">🔐 Đăng Nhập</a>
        <a class="menu disb" href="index.php?quanly=dangki">💡 Đăng Ký</a>
    <?php else: ?>
        <a class="menu disb" href="index.php?quanly=thongtintaikhoan" >👽 Trang Cá Nhân</a>
        <a class="menu disb" href="index.php?quanly=dangxuat">Đăng Xuất</a>
    <?php endif; */?>
    <hr>
    <?php if (!empty($theloaiArray)): ?>
        <div class="nav-tools menu">
            <div class="title">Thể Loại</div>
            <?php foreach ($theloaiArray as $theloai) { ?>
                <a class="nav-sub" href="index.php?quanly=truyen&category[]=<?php echo $theloai; ?>">
                    📂 <?php echo $theloai; ?>
                </a>
            <?php } ?>

        </div>
    <?php else: ?>
        <p>Không có dữ liệu thể loại</p>
    <?php endif; ?>
    <hr>
    <a class="menu box disb" href="index.php?quanly=truyen&moiCapNhat=truyenMoi">Thịnh hành</a>
    <a class="menu box disb" href="index.php?quanly=truyen&luotDoc=all">Đọc nhiều</a>
    <a class="menu box disb" href="index.php?quanly=truyen&danhgia=all">Đánh giá</a>
    <a class="menu box disb" href="index.php?quanly=truyen&decu=all">Đề cử</a>
    <a class="menu box disb" href="index.php?quanly=truyen&like=yeuthich">Yêu thích</a>
    <a class="menu box disb" href="index.php?quanly=truyen&binhluan=comment">Thảo luận</a>
    <br><br><br><br><br><br><br><br><br><br><center>ConMeoDev</center><br><br><br><br><br>
</div>

<div class="nav-tools menu">

    <input id="searchInput" class="timkiem search-input" type="text" placeholder="Tìm kiếm..."onkeypress="handleKeyPress(event)">
    <button class="button-timkiem search-button" type="button" onclick="search()">Tìm truyện</button>

    <hr>
    <button onclick="doiTheme('toi')">Tối</button>
    <button onclick="doiTheme('')">Sáng</button>
    |
    <button onclick="doiTheme('mauhong')">Hồng</button>
    <button onclick="doiTheme('mauxanhla')">Lục</button>
    <button onclick="doiTheme('sangne')">Lam</button>
    <button onclick="doiTheme('mautim')">Tím</button>

</div>
<script>
function doiTheme(themeName) {
  const root = document.documentElement;
  root.className = "";

  if (themeName) {
    root.classList.add(themeName);
  }
  
  // Lưu theme
  localStorage.setItem("theme", themeName);

  // Lấy giá trị màu từ biến CSS
  const primaryColor = getComputedStyle(root)
    .getPropertyValue('--primary-bg-color')
    .trim();

  // Cập nhật vào meta theme-color
  const themeMeta = document.querySelector('#theme-color-meta');
  if (themeMeta && primaryColor) {
    themeMeta.setAttribute('content', primaryColor);
  }
}

window.addEventListener("DOMContentLoaded", () => {
  const theme = localStorage.getItem("theme");
  if (theme) {
    doiTheme(theme);
  } else {
    doiTheme(""); // Hoặc theme mặc định
  }
});
function handleKeyPress(event) {
        // Kiểm tra xem phím Enter (keyCode 13) đã được nhấn không
    if (event.keyCode === 13) {
            // Gọi hàm search() khi Enter được nhấn
        search();
    }
}

function search() {
        // Lấy giá trị từ ô nhập liệu tìm kiếm
    var searchTerm = document.getElementById('searchInput').value.toLowerCase();

        // Chuyển hướng đến trang kết quả tìm kiếm với tham số truyền vào
    window.location.href = 'index.php?quanly=truyen&search=' + encodeURIComponent(searchTerm);
}
function showcaidat() {
    $('#caidat').toggle(400, function() {
        if ($(this).is(':visible')) {
            $('body').css('overflow', 'hidden'); // Ẩn scroll khi mở menu
        } else {
            $('body').css('overflow', ''); // Bật lại scroll khi đóng menu
        }
    });
}
</script>