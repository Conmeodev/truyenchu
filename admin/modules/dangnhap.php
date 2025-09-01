<?php
include('./config/config.php');

// Kiểm tra nếu người dùng đã đăng nhập, chuyển hướng về trang chính
if (isset($_SESSION['id_admin'])) {
    header("Location: index.php");
    exit();
}

// Kiểm tra nếu có dữ liệu đăng nhập được submit từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($mysqli, $_POST["email"]);
    $matkhau = mysqli_real_escape_string($mysqli, $_POST["matkhau"]);

    // Kiểm tra thông tin đăng nhập từ bảng tbl_admin
    $sql_kiemtra = "SELECT * FROM tbl_admin WHERE email='$email'";
    $result_kiemtra = mysqli_query($mysqli, $sql_kiemtra);

    if ($result_kiemtra) {
        $row_admin = mysqli_fetch_assoc($result_kiemtra);

        // Kiểm tra mật khẩu
        if ($row_admin && $matkhau == $row_admin['matkhau']) {
            // Lưu thông tin người dùng vào session
            $_SESSION['id_admin'] = $row_admin['id_admin'];
            $_SESSION['ten'] = $row_admin['ten'];
            $_SESSION['role_id'] = $row_admin['role_id'];

            // Chuyển hướng về trang chính
            header("Location: index.php?action=trangchu&query=home");
            exit();
        } else {
            $error_message = "Thông tin đăng nhập không đúng.";
        }
    } else {
        echo "Lỗi truy vấn CSDL: " . mysqli_error($mysqli);
    }
}

mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <!-- Bootstrap CSS -->
    <style>


#main-content {
    background: url(css/img/index.jpg) no-repeat center center/cover!important;
    height: 100vh; /* 100% của viewport height */
    position: fixed;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    text-align: center;
    width: 100%;
}

.greeting {
    font-size: 24px;
    margin-bottom: 20px;
}

.waiting-message {
    font-size: 18px;
}
.col-md-6 {
    background-color: #fff;
    color: #454545;
    padding: 20px;
    border-radius: 20px;
    margin-bottom: 100px;
}
</style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
<div id="main-content">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Đăng Nhập</h2>
                <?php
                if (isset($error_message)) {
                    echo '<div class="alert alert-danger">' . $error_message . '</div>';
                }
                ?>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="matkhau">Mật Khẩu:</label>
                        <input type="password" class="form-control" id="matkhau" name="matkhau" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Đăng Nhập</button>
                </form>
            </div>
        </div>
    </div>
    </div>
</body>

</html>
