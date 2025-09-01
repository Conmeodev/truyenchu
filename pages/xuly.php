<?php
// Kết nối CSDL và kiểm tra kết nối (sử dụng kết nối CSDL giống như bạn đã làm trong các trang khác)

// Kiểm tra xem có tham số truyền vào không
if ( isset($_GET['id_truyen']) && isset($_GET['id_chuong'])) {
    // Lấy giá trị tham số truyền vào
    $id_user = $_SESSION['id_user'];
    $id_truyen = $_GET['id_truyen'];
    $id_chuong = $_GET['id_chuong'];

    // Chuẩn bị câu lệnh SQL để xóa dữ liệu từ bảng
    $sql_delete = "DELETE FROM tbl_reading_status WHERE id_user = $id_user AND id_truyen = $id_truyen AND id_chuong = $id_chuong";

    // Thực hiện truy vấn xóa
    $result_delete = $mysqli->query($sql_delete);

    if ($result_delete) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    } else {
        echo "Lỗi khi xóa dữ liệu: " . $mysqli->error;
    }
// ...
} else {
    echo "Thiếu tham số cần thiết: " . $mysqli->error;
}
// ...

// Đóng kết nối CSDL
$mysqli->close();
?>
