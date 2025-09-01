<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Home</title>
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
    </style>
</head>
<body>

<div id="main-content">
<?php
    // Kiểm tra xem có tồn tại SESSION không
    if (isset($_SESSION['role_id'])) {
        $role_id = $_SESSION['role_id'];

        if ($role_id == 1 || $role_id == 2) {
        } elseif ($role_id == 3) {
            echo "<p class='waiting-message'>Xin vui lòng chờ xét duyệt.</p>";
        }
    } else {
        // Nếu không có SESSION, chuyển hướng đến trang đăng nhập
        header("Location: index.php?action=dangnhap&query=dangnhap");
        exit();
    }
    ?>
</div>

</body>
</html>

