<?php
// Kiểm tra nếu có dữ liệu được gửi từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $commentContent = mysqli_real_escape_string($mysqli, $_POST["comment"]);
    $idTruyen = mysqli_real_escape_string($mysqli, $_POST["id_truyen"]);

    // Kiểm tra xem người dùng đã đăng nhập hay chưa
    if (isset($_SESSION['id_user'])) {
        // Lấy thông tin người dùng từ session
        $idUser = $_SESSION['id_user'];

        // Thêm bình luận vào CSDL
        $insertCommentQuery = "INSERT INTO tbl_binhluan (noidung, ngaybinhluan, id_user, id_truyen)
                               VALUES ('$commentContent', NOW(), $idUser, $idTruyen)";

        if (mysqli_query($mysqli, $insertCommentQuery)) {
            // Bình luận được thêm thành công
            header("Location: " . $_SERVER["HTTP_REFERER"]);
            exit();
        } else {
            // Lỗi khi thêm bình luận
            echo "Lỗi khi thêm bình luận: " . mysqli_error($mysqli);
        }
    } else {
        // Người dùng chưa đăng nhập, có thể chuyển hướng hoặc xử lý theo ý muốn
        echo "Vui lòng đăng nhập để bình luận.";
    }
} else {
    // Dữ liệu không được gửi từ form, có thể xử lý thêm logic nếu cần
    echo "Không có dữ liệu được gửi từ form.";
}

// Đóng kết nối CSDL
mysqli_close($mysqli);
?>
