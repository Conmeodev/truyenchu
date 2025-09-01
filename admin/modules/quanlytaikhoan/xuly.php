<?php

// Kiểm tra xem có tham số id được truyền từ URL không
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_admin = $_GET['id'];

    // Truy vấn để lấy dữ liệu người dùng cần sửa
    $sql = "SELECT * FROM tbl_admin WHERE id_admin = $id_admin";
    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Kiểm tra xem có sự thay đổi về role_id hay không
        if (isset($_POST["role_id"]) && $_POST["role_id"] != $row["role_id"]) {
            // Nếu có sự thay đổi về role_id, thực hiện cập nhật thông tin người dùng
            $update_sql = "UPDATE tbl_admin SET ten='{$_POST['ten']}', email='{$_POST['email']}', role_id={$_POST['role_id']} WHERE id_admin = $id_admin";
            $update_result = mysqli_query($mysqli, $update_sql);

            if ($update_result) {
                header("Location: index.php?action=quanlytaikhoan&query=lietke");
            } else {
                echo "Lỗi khi cập nhật người dùng: " . mysqli_error($mysqli);
            }
        } else {
            // Nếu không có sự thay đổi về role_id, thực hiện cập nhật thông tin người dùng khác (nếu có)
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
                $ten_moi = mysqli_real_escape_string($mysqli, $_POST['ten']);
                $email_moi = mysqli_real_escape_string($mysqli, $_POST['email']);

                $update_sql = "UPDATE tbl_admin SET ten='$ten_moi', email='$email_moi' WHERE id_admin = $id_admin";
                $update_result = mysqli_query($mysqli, $update_sql);

                if ($update_result) {
                    header("Location: index.php?action=quanlytaikhoan&query=lietke");
                } else {
                    echo "Lỗi khi cập nhật người dùng: " . mysqli_error($mysqli);
                }
            }

            // Kiểm tra và xử lý duyệt/ngừng duyệt
            if (isset($_POST["duyet"])) {
                $update_sql = "UPDATE tbl_admin SET role_id = 2 WHERE id_admin = $id_admin";
                $update_result = mysqli_query($mysqli, $update_sql);

                if ($update_result) {
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                } else {
                    echo "Lỗi khi duyệt người dùng: " . mysqli_error($mysqli);
                }
            }

            // Kiểm tra và xử lý xóa
            if (isset($_POST["xoa"])) {
                $delete_sql = "DELETE FROM tbl_admin WHERE id_admin = $id_admin";
                $delete_result = mysqli_query($mysqli, $delete_sql);

                if ($delete_result) {
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                } else {
                    echo "Lỗi khi xóa người dùng: " . mysqli_error($mysqli);
                }
            }
        }
    } else {
        echo "Người dùng không tồn tại.";
    }
} else {
    echo "Tham số id không hợp lệ.";
}

// Đóng kết nối CSDL
mysqli_close($mysqli);
?>
