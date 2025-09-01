<?php
// Kết nối CSDL (sử dụng biến $mysqli đã được khai báo trước đó)

// Khởi tạo biến $id_truyen trước khi sử dụng
$id_truyen = isset($_GET['id_truyen']) ? $_GET['id_truyen'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Kiểm tra xem $id_truyen có giá trị không
    if ($id_truyen !== null) {
        // Thực hiện cập nhật dữ liệu trong CSDL dựa trên $id_truyen và $decu
        $sqlUpdateDecu = "UPDATE tbl_truyen SET decu = decu + 1 WHERE id_truyen = $id_truyen";
        $resultUpdateDecu = $mysqli->query($sqlUpdateDecu);

        if ($resultUpdateDecu) {
            header("Location: index.php?quanly=thongtintruyen&id_truyen=$id_truyen");

        } else {
            echo 'error';
        }
    } else {
        echo 'id_truyen is not set';
    }
} else {
    // In giá trị của $id_truyen nếu không phải là POST request
    echo $id_truyen;
}
?>
