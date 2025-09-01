<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nếu là bước "Đăng truyện"
    if (isset($_POST["dangtruyen"])) {
        $tieude = mysqli_real_escape_string($mysqli, $_POST["tieude"]);
        $id_admin = $_SESSION['id_admin']; // Lấy id_admin tạm thời, bạn có thể thay thế bằng phương thức xác thực người dùng
        $tomtat = $_POST["tomtat"];
        $tacgia = mysqli_real_escape_string($mysqli, $_POST["tacgia"]);
        $status_tt = isset($_POST["trangthai"]) ? $_POST["trangthai"] : 0; // Lấy giá trị trạng thái từ form

        // Xử lý upload hình ảnh
        $hinhanh = '';
        if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] == 0) {
            $target_dir = "modules/quanlytruyen/uploads/";
            $target_file = $target_dir . basename($_FILES["hinhanh"]["name"]);
            move_uploaded_file($_FILES["hinhanh"]["tmp_name"], $target_file);
            $hinhanh = basename($_FILES["hinhanh"]["name"]);
        }

        // Thêm truyện mới vào bảng tbl_truyen
        $sql_truyen = "INSERT INTO tbl_truyen (tieude, hinhanh, tomtat, tacgia, ngaydang, status_tt, id_admin) 
                       VALUES ('$tieude', '$hinhanh', '$tomtat', '$tacgia', NOW(), $status_tt, $id_admin )";

        $result_truyen = mysqli_query($mysqli, $sql_truyen);

        if ($result_truyen) {
            $id_truyen_moi = mysqli_insert_id($mysqli);

            // Lấy danh sách thể loại được chọn từ form
            if (isset($_POST['theloai']) && is_array($_POST['theloai'])) {
                foreach ($_POST['theloai'] as $id_theloai) {
                    // Thêm vào bảng liên kết nhiều nhiều
                    $sql_lienkethai = "INSERT INTO tbl_truyen_theloai (id_truyen, id_theloai) 
                                       VALUES ($id_truyen_moi, $id_theloai)";
                    mysqli_query($mysqli, $sql_lienkethai);
                }
            }

            // Chuyển hướng đến trang themchuong.php với thông tin truyền đi
            header("Location: index.php?action=quanlytruyen&query=themchuong&id_truyen=$id_truyen_moi");
            exit();
        } else {
            echo "Lỗi khi thêm truyện: " . mysqli_error($mysqli);
        }
    }


    // Nếu là bước "Thêm chương"
    if (isset($_POST["themchuong"])) {
        $noidung = mysqli_real_escape_string($mysqli, $_POST["noidung"]);
        $sochuong = mysqli_real_escape_string($mysqli, $_POST["sochuong"]);
        $id_truyen = mysqli_real_escape_string($mysqli, $_POST["id_truyen"]);
        $tenchuong = mysqli_real_escape_string($mysqli, $_POST["tenchuong"]);
    
        // Lấy thời gian hiện tại từ múi giờ Hồ Chí Minh
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $thoigian = date('Y-m-d H:i:s');
    
        // Thêm nội dung chương vào bảng tbl_chuong
        $sql_chuong = "INSERT INTO tbl_chuong (tenchuong, noidung, sochuong, thoigian, id_truyen) 
                       VALUES ('$tenchuong', '$noidung', '$sochuong', '$thoigian', $id_truyen)";
    
        $result_chuong = mysqli_query($mysqli, $sql_chuong);
    
        if ($result_chuong) {
            // Chuyển hướng đến trang themchuong.php với thông tin truyền đi
            header("Location: index.php?action=quanlytruyen&query=themchuong&id_truyen=$id_truyen");
            exit();
        } else {
            echo "Lỗi khi thêm chương: " . mysqli_error($mysqli);
        }
    }
}    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["capnhat"])) {
        $id_truyen = $_POST["id_truyen"];
        $tieude = mysqli_real_escape_string($mysqli, $_POST["tieude"]);
        $tomtat = $_POST["tomtat"];
        $tacgia = mysqli_real_escape_string($mysqli, $_POST["tacgia"]);
        $status_tt = isset($_POST["trangthai"]) ? $_POST["trangthai"] : 0; // Lấy giá trị trạng thái từ form

        // Xử lý upload hình ảnh mới nếu có
        $hinhanh = '';
        if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] == 0) {
            $target_dir = "modules/quanlytruyen/uploads/";
            $target_file = $target_dir . basename($_FILES["hinhanh"]["name"]);
            move_uploaded_file($_FILES["hinhanh"]["tmp_name"], $target_file);
            $hinhanh = basename($_FILES["hinhanh"]["name"]);

            // Cập nhật thông tin truyện với ảnh mới
            $sql_capnhat = "UPDATE tbl_truyen SET tieude='$tieude', tomtat='$tomtat', tacgia='$tacgia', status_tt=$status_tt, hinhanh='$hinhanh' WHERE id_truyen=$id_truyen";
        } else {
            // Cập nhật thông tin truyện không có ảnh mới
            $sql_capnhat = "UPDATE tbl_truyen SET tieude='$tieude', tomtat='$tomtat', tacgia='$tacgia', status_tt=$status_tt WHERE id_truyen=$id_truyen";
        }

        $result_capnhat = mysqli_query($mysqli, $sql_capnhat);

        if ($result_capnhat) {
            // Xóa hết thể loại của truyện
            $sql_xoa_theloai = "DELETE FROM tbl_truyen_theloai WHERE id_truyen=$id_truyen";
            mysqli_query($mysqli, $sql_xoa_theloai);

            // Thêm lại thể loại mới vào bảng tbl_truyen_theloai
            if (isset($_POST['theloai']) && is_array($_POST['theloai'])) {
                foreach ($_POST['theloai'] as $id_theloai) {
                    $sql_them_theloai = "INSERT INTO tbl_truyen_theloai (id_truyen, id_theloai) VALUES ($id_truyen, $id_theloai)";
                    mysqli_query($mysqli, $sql_them_theloai);
                }
            }

            header("Location:index.php?action=quanlytruyen&query=sua&id_truyen=$id_truyen");
            exit();
        } else {
            echo "Lỗi khi cập nhật thông tin truyện: " . mysqli_error($mysqli);
        }
    }
}

if (isset($_GET["id_truyen"])) {
    $id_truyen = $_GET["id_truyen"];

    // Xóa chương của truyện
    $sql_xoa_chuong = "DELETE FROM tbl_chuong WHERE id_truyen=$id_truyen";
    $result_xoa_chuong = mysqli_query($mysqli, $sql_xoa_chuong);

    // Xóa thể loại của truyện
    $sql_xoa_theloai = "DELETE FROM tbl_truyen_theloai WHERE id_truyen=$id_truyen";
    $result_xoa_theloai = mysqli_query($mysqli, $sql_xoa_theloai);

    // Xóa truyện
    $sql_xoa_truyen = "DELETE FROM tbl_truyen WHERE id_truyen=$id_truyen";
    $result_xoa_truyen = mysqli_query($mysqli, $sql_xoa_truyen);

    if ($result_xoa_truyen) {
        // Chuyển hướng về trang lietke.php sau khi xóa thành công
        header("Location:index.php?action=quanlytruyen&query=lietke");
        exit();
    } else {
        echo "Lỗi khi xóa truyện: " . mysqli_error($mysqli);
    }
} else {
    echo "Không có truyện nào được chọn.";
}
mysqli_close($mysqli);
?>
