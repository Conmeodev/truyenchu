<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy giá trị từ các thanh trượt
    $tinhcach = $_POST['tinhcach'];
    $cottruyen = $_POST['cottruyen'];
    $bocuc = $_POST['bocuc'];
    $chatluong = $_POST['chatluong'];
    // Tính tổng điểm
    $tongdiem = ($tinhcach + $cottruyen + $bocuc + $chatluong) / 4;
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $ngaydanhgia = date('Y-m-d H:i:s');
    
    // Lấy giá trị của ô nhập nội dung đánh giá
    $noidungdg = $mysqli->real_escape_string($_POST['noidung']);

    // Lấy id_user từ session (điều này giả sử bạn đã lưu id_user vào session khi người dùng đăng nhập)
    if (isset($_SESSION['id_user'])) {
        $id_user = $_SESSION['id_user'];
    } else {
        echo "Lỗi: Không tìm thấy thông tin người dùng!";
        exit;
    }

    // Lấy id_truyen từ URL (giả sử id_truyen được truyền qua phương thức GET)
    if (isset($_GET['id_truyen'])) {
        $id_truyen = $_GET['id_truyen'];
    } else {
        echo "Lỗi: Không tìm thấy thông tin truyện!";
        exit;
    }

    // Thực hiện truy vấn cập nhật
    $queryInsertDanhGia = "INSERT INTO tbl_danhgia 
    (id_truyen, id_user, tinhcach, cottruyen, ngaydanhgia, bocuc, chatluong, tongdiem, noidung)
    VALUES 
    ($id_truyen, $id_user, $tinhcach, $cottruyen, '$ngaydanhgia', $bocuc, $chatluong, $tongdiem, '$noidungdg')";

$resultInsertDanhGia = $mysqli->query($queryInsertDanhGia);

if ($resultInsertDanhGia) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit();
} else {
echo "Có lỗi xảy ra khi thêm đánh giá: " . $mysqli->error;
}

}
?>
