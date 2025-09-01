<?php

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id_theloai"])) {
    $id_theloai = $_GET["id_theloai"];

    // Lấy thông tin thể loại từ cơ sở dữ liệu
    $sql_lay_theloai = "SELECT * FROM tbl_theloai WHERE id_theloai = $id_theloai";
    $result_lay_theloai = $mysqli->query($sql_lay_theloai);

    if ($result_lay_theloai->num_rows > 0) {
        $row_theloai = $result_lay_theloai->fetch_assoc();
        $tentheloai = $row_theloai["tentheloai"];
        $thutu = $row_theloai["thutu"];
    } else {
        echo "Không tìm thấy thể loại.";
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
    <title>Sửa Thể loại</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>

        form {
            max-width: 200px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <h2>Sửa Thể loại</h2>
    <form method="post" action="index.php?action=quanlytheloai&query=xuly&id_theloai=<?php echo $id_theloai; ?>">
        <div class="form-group">
            <label for="tentheloai">Tên Thể loại:</label>
            <input type="text" name="tentheloai" value="<?php echo $tentheloai; ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="thutu">Thứ tự:</label>
            <input type="text" name="thutu" value="<?php echo $thutu; ?>" class="form-control" required>
        </div>

        <input type="submit" name="suatheloai" value="Sửa Thể loại" class="btn btn-primary">
    </form>
    
    <!-- Bootstrap JS and jQuery (add these scripts at the end of the body) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
