<?php

// Truy vấn CSDL để lấy đường dẫn ảnh từ bảng tbl_anhtrangbia
$sql = "SELECT hinhanh FROM tbl_anhtrangbia WHERE tinhtrang = 1 ORDER BY RAND() LIMIT 1";
$result = $mysqli->query($sql);

// Kiểm tra và lấy đường dẫn ảnh
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $imagePath = './admin/modules/quanlyslide/uploads/' . $row['hinhanh'];
} else {
    // Nếu không có dữ liệu, sử dụng ảnh mặc định hoặc đặt giá trị khác tùy ý
    $imagePath = '../admin/modules/quanlyslide/uploads/bia1.webp';
}
?>

<!-- Thẻ img cho hiển thị ảnh -->
<img class="top-bg-op-box" src="<?php echo $imagePath; ?>" alt="Background Image">
<main>
  <div class="container_vc123">
        <div class="left-column_vc123">
            <ul class="nav_vc123">
                <li class="nav-item_vc123"><i class="fa-regular fa-user"></i> Hồ sơ</li>
                <li class="nav-item_vc123"><i class="fa-solid fa-book-open"></i> Tủ truyện</li>
                <li class="nav-item_vc123"><i class="fa-solid fa-gear"></i> Cài đặt</li>
                <li class="nav-item_vc123"><i class="fa-solid fa-piggy-bank"></i> Tài sản</li>
                <li class="nav-item_vc123"><i class="fa-regular fa-thumbs-up"></i> Mua kẹo</li>
                <li class="nav-item_vc123"><i class="fa-solid fa-circle-arrow-up"></i> Nâng cấp</li>
                <li class="nav-item_vc123"><i class="fa-solid fa-gifts"></i> Nhận thưởng</li>
                <li class="nav-item_vc123"><i class="fa-regular fa-bell"></i> Thông báo</li>
                <li class="nav-item_vc123"><i class="fa-regular fa-circle-question"></i> Trợ giúp & Báo lỗi</li>
            </ul>
        </div>
        <div class="right-column_vc123">
            <ul class="nav_vc123">
                <li class="nav-item_vc123 nav-item-horizontal_vc123">Hồ sơ</li>
                <li class="nav-item_vc123 nav-item-horizontal_vc123">Bảo mật</li>
                <li class="nav-item_vc123 nav-item-horizontal_vc123">Cấu hình</li>
            </ul>
          
            <?php
// Giả sử bạn đã kết nối cơ sở dữ liệu và có biến $mysqli
if (isset($_POST['suathongtin'])) {
    // Lấy dữ liệu từ POST
    $userId = $_SESSION['id_user']; // Đây là một giả định, bạn cần thay đổi nó tùy thuộc vào cách bạn lấy id_user
    $newDisplayName = $_POST['display-name'];
    $newBirthDate = $_POST['birth-date'];
    $newPhoneNumber = $_POST['phone-number'];
    $newEmail = $_POST['email'];

    // Cập nhật thông tin người dùng trong bảng tbl_user
    $sqlUpdateInfo = "UPDATE tbl_user SET tenuser = '$newDisplayName', ngaysinh = '$newBirthDate', sodienthoai = '$newPhoneNumber', email = '$newEmail' WHERE id_user = $userId";

    if ($mysqli->query($sqlUpdateInfo) === TRUE) {
        echo "Cập nhật thông tin thành công";
    } else {
        echo "Lỗi cập nhật thông tin: " . $mysqli->error;
    }

    // Kiểm tra xem người dùng đã chọn tệp mới để tải lên hay không
    if ($_FILES['avatar']['error'] == 0) {
        // Xử lý tải lên ảnh mới
        $uploadDir = "./assets/image/";
        $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
            // Nếu tải lên ảnh thành công, cập nhật đường dẫn ảnh mới vào cơ sở dữ liệu
            $newAvatar = basename($_FILES['avatar']['name']);
            $sqlUpdateAvatar = "UPDATE tbl_user SET avatar = '$newAvatar' WHERE id_user = $userId";

            if ($mysqli->query($sqlUpdateAvatar) === TRUE) {
                echo "Cập nhật ảnh đại diện thành công";
            } else {
                echo "Lỗi cập nhật ảnh đại diện: " . $mysqli->error;
            }
        } else {
            echo "Lỗi khi tải lên ảnh.";
        }
    }
}
// Lấy id_user từ session hoặc bất kỳ nguồn nào khác
if (isset($_SESSION['id_user'])) {
    // Lấy giá trị của id_user từ session
    $id_user = $_SESSION['id_user']; // Đây là một giả định, bạn cần thay đổi nó tùy thuộc vào cách bạn lấy id_user

// Truy vấn SQL để lấy thông tin người dùng từ bảng tbl_user
$queryUserInfo = "SELECT id_user, tenuser, email,avatar, ngaysinh, sodienthoai FROM tbl_user WHERE id_user = $id_user";

// Thực hiện truy vấn và lấy dữ liệu
$resultUserInfo = $mysqli->query($queryUserInfo);

// Kiểm tra và hiển thị thông tin người dùng
if ($resultUserInfo && $resultUserInfo->num_rows > 0) {
    $userInfo = $resultUserInfo->fetch_assoc();
    echo '<form id="update-form" action="" method="post" enctype="multipart/form-data">';
    echo '<div class="personal-info_vc123">';
    echo '<label for="avatar" class="label_vc123">Ảnh đại diện:</label>';
    echo '<img src="./assets/image/' . $userInfo['avatar'] .'" alt="Ảnh đại diện" class="profile-picture_vc123">';
    echo '<input type="file" id="avatar" name="avatar" accept="image/*">';

    echo '<label for="display-name" class="label_vc123">Tên:</label>';
    echo '<input type="text" id="display-name" name="display-name" class="input-field_vc123" value="' . $userInfo['tenuser'] . '">';
    
    echo ' <label for="birth-date" class="label_vc123">Năm sinh:</label>';
    echo '<input type="text" id="birth-date" name="birth-date" class="input-field_vc123" value="' . $userInfo['ngaysinh'] . '">';
    
    echo '<label for="phone-number" class="label_vc123">Số điện thoại:</label>';
    echo '<input type="text" id="phone-number" name="phone-number" class="input-field_vc123" value="' . $userInfo['sodienthoai'] . '">';
    
    echo '<label for="email" class="label_vc123">Email:</label>';
    echo '<input type="text" id="email" name="email" class="input-field_vc123" value="' . $userInfo['email'] . '">';
    
    echo '</div>';
    echo '<button type="submit" name="suathongtin" class="update-button_vc123">Cập nhật</button>';
    echo '</form>';
    
} else {
    echo 'Không tìm thấy thông tin người dùng.';
}
}
?>

        </div>
    </div>
</main>