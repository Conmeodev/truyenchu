<?php

// Kiểm tra nếu id_chuong được truyền vào từ URL
if (isset($_GET["id_chuong"])) {
    $id_chuong = $_GET["id_chuong"];
    $id_truyen = $_GET["id_truyen"];

    // Lấy thông tin chi tiết của chương từ bảng tbl_chuong
    $sql_lay_chuong = "SELECT * FROM tbl_chuong WHERE id_chuong = $id_chuong";
    $result_lay_chuong = $mysqli->query($sql_lay_chuong);

    if ($result_lay_chuong->num_rows > 0) {
        $row_chuong = $result_lay_chuong->fetch_assoc();
        $noidung = $row_chuong["noidung"];
        $sochuong = $row_chuong["sochuong"];
        $tenchuong = $row_chuong["tenchuong"];
        $id_truyen = $row_chuong["id_truyen"];
    } else {
        echo "Không tìm thấy chương.";
        exit();
    }

    // Kiểm tra nếu người dùng đã ấn nút "Lưu Sửa" trên form
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["luuchuong"])) {
        // Lấy dữ liệu từ form
        $noidung_moi = $_POST["noidung"];
        $tenchuong_moi = $_POST["tenchuong"];

        // Cập nhật nội dung và tên chương trong CSDL
        $sql_cap_nhat = "UPDATE tbl_chuong SET noidung = '$noidung_moi', tenchuong = '$tenchuong_moi' WHERE id_chuong = $id_chuong";

        // Thực hiện câu truy vấn cập nhật
        $result_sua_chuong = $mysqli->query($sql_cap_nhat);

        if ($result_sua_chuong) {
            // Chuyển hướng về trang lietke.php sau khi sửa thành công
            header("Location: index.php?action=quanlychuong&query=sua&id_chuong={$row_chuong['id_chuong']}&id_truyen=$id_truyen");
            exit();
        } else {
            echo "Lỗi khi sửa nội dung chương: " . mysqli_error($mysqli);
        }
    }
}

mysqli_close($mysqli);
?>
