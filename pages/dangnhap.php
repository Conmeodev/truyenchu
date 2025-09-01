<?php
header("Location:/");exit();
// Kiểm tra nếu người dùng đã đăng nhập, chuyển hướng về trang chính
if (isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit();
}

// Kiểm tra nếu có dữ liệu đăng nhập được submit từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($mysqli, $_POST["email"]);
    $matkhau = mysqli_real_escape_string($mysqli, $_POST["matkhau"]);

    // Kiểm tra thông tin đăng nhập từ bảng tbl_user
    $sql_kiemtra = "SELECT * FROM tbl_user WHERE email='$email'";
    $result_kiemtra = mysqli_query($mysqli, $sql_kiemtra);

    if ($result_kiemtra) {
        $row_user = mysqli_fetch_assoc($result_kiemtra);

        // Kiểm tra mật khẩu
        if ($row_user && $matkhau == $row_user['matkhau']) {
            // Lưu thông tin người dùng vào session
            $_SESSION['id_user'] = $row_user['id_user'];
            $_SESSION['tenuser'] = $row_user['tenuser'];
            $_SESSION['avatar'] = $row_user['avatar'];

            // Chuyển hướng về trang chính
            header("Location: index.php");
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

    <div class="container-mt-5">
        <div class="row-justify-content-center">
            <div class="col-md-6">
                <h2>Đăng Nhập</h2>
                <?php
                if (isset($error_message)) {
                    echo '<div class="alert-alert-danger">' . $error_message . '</div>';
                }
                ?>
                <form method="post" action="">
                    <div class="form-group-123">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control-123" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="matkhau">Mật Khẩu:</label>
                        <input type="password" class="form-control-123" id="matkhau" name="matkhau" required>
                    </div>
                    <button type="submit" class="btn-btn-primary123">Đăng Nhập</button>
                </form>
            </div>
        </div>
    </div>
