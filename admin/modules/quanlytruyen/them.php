<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ form
    $tieude = $_POST["tieude"];
    $noidung = $_POST["noidung"];
    $tomtat = $_POST["tomtat"];
    // Lấy id_admin tạm thời, bạn có thể thay thế bằng phương thức xác thực người dùng
    $id_admin = 1;

    // Xử lý upload hình ảnh
    $hinhanh = ''; // Biến để lưu tên hình ảnh
    if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] == 0) {
        $target_dir = "uploads/"; // Thư mục lưu trữ hình ảnh
        $target_file = $target_dir . basename($_FILES["hinhanh"]["name"]);
        move_uploaded_file($_FILES["hinhanh"]["tmp_name"], $target_file);
        $hinhanh = basename($_FILES["hinhanh"]["name"]);
    }

    // Thêm truyện mới vào cơ sở dữ liệu

}
?>



<div class="container">
    <h2 class="text-center mt-4 mb-4">Thêm Truyện Mới</h2>
    <form method="post" action="index.php?action=quanlytruyen&query=xuly" enctype="multipart/form-data">
        <div class="form-group">
            <label for="tieude">Tên truyện:</label>
            <input type="text" class="form-control" name="tieude" required>
        </div>
        <div class="form-group">
            <label for="tieude">Tác giả:</label>
            <input type="text" class="form-control" name="tacgia" required>
        </div>

        <div class="form-group">
            <label for="tomtat">Tóm tắt:</label>
            <textarea class="form-control" name="tomtat" rows="2" required></textarea>
        </div>

        <div class="form-group">
            <label for="hinhanh">Hình ảnh:</label>
            <input type="file" class="form-control-file" name="hinhanh" accept="image/*">
        </div>

        <div class="form-group">
            <label for="theloai">Thể loại:</label><br>
            <?php
            // Hiển thị danh sách thể loại từ bảng tbl_theloai
            $sql_theloai = "SELECT * FROM tbl_theloai";
            $result_theloai = mysqli_query($mysqli, $sql_theloai);

            if ($result_theloai->num_rows > 0) {
                while ($row_theloai = $result_theloai->fetch_assoc()) {
                    echo '<div class="form-check">';
                    echo '<input class="form-check-input" type="checkbox" name="theloai[]" value="' . $row_theloai['id_theloai'] . '">';
                    echo '<label class="form-check-label">' . $row_theloai['tentheloai'] . '</label>';
                    echo '</div>';
                }
            } else {
                echo "Không có thể loại nào.";
            }
            ?>
        </div>
        <div class="form-group">
    <label for="trangthai">Trạng thái:</label><br>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="trangthai" value="0" checked>
        <label class="form-check-label">Đang ra</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="trangthai" value="1">
        <label class="form-check-label">Hoàn thành</label>
    </div>
</div>
        <button type="submit" class="btn btn-primary" name="dangtruyen">Thêm Truyện</button>
    </form>
</div>
