<?php
// Kết nối CSDL (sử dụng biến $mysqli đã được khai báo trước đó)

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id_truyen']) && is_numeric($_GET['id_truyen'])) {
        $idTruyen = $_GET['id_truyen'];

        // Thực hiện cập nhật dữ liệu trong CSDL dựa trên $idTruyen
        $sqlUpdateFavorite = "UPDATE tbl_truyen SET yeuthich = yeuthich + 1 WHERE id_truyen = ?";
        
        // Sử dụng câu lệnh chuẩn bị để tránh SQL injection
        $stmt = $mysqli->prepare($sqlUpdateFavorite);
        $stmt->bind_param("i", $idTruyen);

        if ($stmt->execute()) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        } else {
            echo 'Error: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        echo 'Invalid id_truyen';
    }
} else {
    echo 'Invalid request method';
}
?>
