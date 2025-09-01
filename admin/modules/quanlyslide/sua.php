<?php

// Include file kết nối database ở đây
// include("connect.php");

// Kiểm tra phương thức là GET và tồn tại id_anhtrangbia
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id_anhtrangbia"])) {
    $id_anhtrangbia = $_GET["id_anhtrangbia"];

    // Lấy thông tin ảnh trang bìa từ cơ sở dữ liệu
    $sql_lay_anhtrangbia = "SELECT * FROM tbl_anhtrangbia WHERE id_anhtrangbia = $id_anhtrangbia";
    $result_lay_anhtrangbia = $mysqli->query($sql_lay_anhtrangbia);

    if ($result_lay_anhtrangbia->num_rows > 0) {
        $row_anhtrangbia = $result_lay_anhtrangbia->fetch_assoc();
        $hinhanh = $row_anhtrangbia["hinhanh"];
        $thutu = $row_anhtrangbia["thutu"];
        $tinhtrang = $row_anhtrangbia["tinhtrang"];
    } else {
        echo "Không tìm thấy ảnh trang bìa.";
        exit();
    }
}

mysqli_close($mysqli);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Ảnh Bìa</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        form {
            max-width: 300px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <h2>Sửa Ảnh Bìa</h2>
    <form method="post" action="index.php?action=quanlyslide&query=xuly&id_anhtrangbia=<?php echo $id_anhtrangbia; ?>" enctype="multipart/form-data">
        <!-- Hiển thị ảnh cũ -->
        <img src="modules/quanlyslide/uploads/<?php echo $hinhanh; ?>" alt="Ảnh Bìa Cũ" class="img-thumbnail">
        
        <div class="form-group">
            <label for="hinhanh">Ảnh Bìa Mới:</label>
            <input type="file" name="hinhanh" class="form-control">
        </div>

        <div class="form-group">
            <label for="thutu">Thứ tự:</label>
            <input type="text" name="thutu" value="<?php echo $thutu; ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="tinhtrang">Trạng thái:</label>
            <select name="tinhtrang" class="form-control" required>
                <option value="1" <?php echo ($tinhtrang == 1) ? 'selected' : ''; ?>>Hiển thị</option>
                <option value="0" <?php echo ($tinhtrang == 0) ? 'selected' : ''; ?>>Ẩn</option>
            </select>
        </div>

        <input type="submit" name="suaanhtrangbia" value="Sửa Ảnh Bìa" class="btn btn-primary">
    </form>

    <!-- Bootstrap JS and jQuery (add these scripts at the end of the body) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
