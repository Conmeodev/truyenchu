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
    
    // Lấy thông tin truyện từ bảng tbl_truyen
    $sql_lay_truyen = "SELECT tieude FROM tbl_truyen WHERE id_truyen = $id_truyen";
    $result_lay_truyen = $mysqli->query($sql_lay_truyen);

    if ($result_lay_truyen->num_rows > 0) {
        $row_truyen = $result_lay_truyen->fetch_assoc();
        $tieude_truyen = $row_truyen["tieude"];
    } else {
        echo "Không tìm thấy truyện.";
        exit();
    }
}

// Kiểm tra nếu người dùng đã ấn nút "Lưu Sửa" trên form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["luuchuong"])) {
    // Lấy dữ liệu từ form
    $noidung_moi = $_POST["noidung"];
    $tenchuong_moi = $_POST["tenchuong"];

    // Cập nhật nội dung và tên chương trong CSDL
    $sql_cap_nhat = "UPDATE tbl_chuong SET noidung = '$noidung_moi', tenchuong = '$tenchuong_moi' WHERE id_chuong = $id_chuong";

    if ($mysqli->query($sql_cap_nhat) === TRUE) {
        echo "Cập nhật thành công!";
    } else {
        echo "Có lỗi xảy ra: " . $mysqli->error;
    }
}

mysqli_close($mysqli);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Chương</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">Sửa Nội Dung Chương</h2>
        <p>Tên Truyện: <?php echo $tieude_truyen; ?></p>
        <p>Chương: <?php echo $sochuong; ?></p>

        <form method="post" action="index.php?action=quanlychuong&query=xuly&id_chuong=<?php echo $id_chuong; ?>&id_truyen=<?php echo $id_truyen; ?>">
            <div class="form-group">
                <label for="tenchuong">Tiêu đề:</label>
                <input type="text" class="form-control" name="tenchuong" value="<?php echo $tenchuong; ?>" required>
            </div>

            <div class="form-group">
                <label for="noidung">Nội dung chương:</label>
                <textarea class="form-control" name="noidung" rows="5" required><?php echo $noidung; ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary" name="luuchuong">Lưu Sửa</button>
        </form>
    </div>

    <!-- jQuery và Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
