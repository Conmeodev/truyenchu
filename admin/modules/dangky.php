<?php
header("Location:/");exit();
include('./config/config.php');

// Kiểm tra nếu người dùng đã đăng nhập, chuyển hướng về trang chính
if (isset($_SESSION['id_admin'])) {
    header("Location: index.php");
    exit();
}

// Kiểm tra nếu có dữ liệu đăng ký được submit từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten = mysqli_real_escape_string($mysqli, $_POST["ten"]);
    $email = mysqli_real_escape_string($mysqli, $_POST["email"]);
    $matkhau = mysqli_real_escape_string($mysqli, $_POST["matkhau"]);

    // Kiểm tra xem email đã tồn tại chưa
    $sql_kiemtra_email = "SELECT * FROM tbl_admin WHERE email='$email'";
    $result_kiemtra_email = mysqli_query($mysqli, $sql_kiemtra_email);

    if ($result_kiemtra_email) {
        if (mysqli_num_rows($result_kiemtra_email) > 0) {
            $error_message = "Email đã tồn tại. Vui lòng sử dụng email khác.";
        } else {
            // Thêm thông tin đăng ký vào cơ sở dữ liệu
            $sql_dangky = "INSERT INTO tbl_admin (ten, email, matkhau,role_id) VALUES ('$ten', '$email', '$matkhau',3)";
            $result_dangky = mysqli_query($mysqli, $sql_dangky);

            if ($result_dangky) {
                // Lưu thông tin người dùng vào session
                $_SESSION['id_admin'] = mysqli_insert_id($mysqli);
                $_SESSION['ten'] = $ten;
                $_SESSION['role_id'] = 3; // Giả sử role_id là 1, bạn có thể thay đổi tùy theo cấu trúc cơ sở dữ liệu của bạn

                // Chuyển hướng về trang chính
                header("Location: index.php?action=trangchu&query=home");
                exit();
            } else {
                $error_message = "Lỗi khi đăng ký: " . mysqli_error($mysqli);
            }
        }
    } else {
        echo "Lỗi truy vấn CSDL: " . mysqli_error($mysqli);
    }
}

mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html lang="en">
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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
<div id="main-content">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Đăng Ký</h2>
                <?php
                if (isset($error_message)) {
                    echo '<div class="alert alert-danger">' . $error_message . '</div>';
                }
                ?>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="ten">Tên:</label>
                        <input type="text" class="form-control" id="ten" name="ten" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="matkhau">Mật Khẩu:</label>
                        <input type="password" class="form-control" id="matkhau" name="matkhau" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Đăng Ký</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

</html>
