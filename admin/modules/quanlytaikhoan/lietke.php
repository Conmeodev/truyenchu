<?php
// Kết nối CSDL

// Truy vấn để lấy toàn bộ dữ liệu từ bảng tbl_admin
$sql = "SELECT * FROM tbl_admin";
$result = mysqli_query($mysqli, $sql);

// Đóng kết nối CSDL
mysqli_close($mysqli);

// Mảng ánh xạ role_id sang tên role
$roleMapping = array(
    1 => 'Admin',
    2 => 'Tác giả',
    3 => 'Người dùng'
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Danh sách người dùng</h2>
        <?php if (mysqli_num_rows($result) > 0) { ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Admin</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Avatar</th>
                        <th>Quyền</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['id_admin']; ?></td>
                            <td><?php echo $row['ten']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['avatar']; ?></td>
                            <td><?php echo $roleMapping[$row['role_id']]; ?></td>
                            <td>
                               <!-- Trong vòng lặp while -->
                                <form method="POST" action="index.php?action=quanlytaikhoan&query=xuly&id=<?php echo $row['id_admin']; ?>">
                                    <?php if ($row['role_id'] == 3) { ?>
                                        <button type="submit" name="duyet" class="btn btn-success btn-sm">Duyệt</button>
                                    <?php } ?>
                                    <a href="index.php?action=quanlytaikhoan&query=sua&id=<?php echo $row['id_admin']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                                    <button type="submit" name="xoa" class="btn btn-danger btn-sm">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>Không có người dùng nào trong CSDL.</p>
        <?php } ?>
    </div>

    <!-- Bootstrap JS và jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
