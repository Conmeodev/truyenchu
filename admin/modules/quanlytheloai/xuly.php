<?php


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["themtheloai"])) {
    $tentheloai = $_POST["tentheloai"];
    $thutu = $_POST["thutu"];

    // Thêm thể loại mới vào bảng tbl_theloai
    $sql_theloai = "INSERT INTO tbl_theloai (tentheloai, thutu) VALUES ('$tentheloai', '$thutu')";
    
    $result_theloai = mysqli_query($mysqli, $sql_theloai);

    if ($result_theloai) {
        // Chuyển hướng về trang lietke_theloai.php sau khi thêm thành công
        header("Location: index.php?action=quanlytheloai&query=lietke");
        exit();
    } else {
        echo "Lỗi khi thêm thể loại: " . mysqli_error($mysqli);
    }
}
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id_theloai"])) {
    $id_theloai = $_GET["id_theloai"];

    // Xóa thể loại từ bảng tbl_theloai
    $sql_xoa_theloai = "DELETE FROM tbl_theloai WHERE id_theloai = $id_theloai";
    $result_xoa_theloai = mysqli_query($mysqli, $sql_xoa_theloai);

    if ($result_xoa_theloai) {
        // Chuyển hướng về trang index.php?action=quanlytheloai&query=lietke sau khi xóa thành công
        header("Location: index.php?action=quanlytheloai&query=lietke");
        exit();
    } else {
        echo "Lỗi khi xóa thể loại: " . mysqli_error($mysqli);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["suatheloai"])) {
    $id_theloai = $_GET["id_theloai"];

    $tentheloai_moi = $_POST["tentheloai"];
    $thutu_moi = $_POST["thutu"];

    // Cập nhật thông tin thể loại trong bảng tbl_theloai
    $sql_sua_theloai = "UPDATE tbl_theloai SET tentheloai = '$tentheloai_moi', thutu = '$thutu_moi' WHERE id_theloai = $id_theloai";
    $result_sua_theloai = mysqli_query($mysqli, $sql_sua_theloai);

    if ($result_sua_theloai) {
        // Chuyển hướng về trang index.php?action=quanlytheloai&query=lietke sau khi sửa thành công
        header("Location: index.php?action=quanlytheloai&query=lietke");
        exit();
    } else {
        echo "Lỗi khi sửa thể loại: " . mysqli_error($mysqli);
    }
}
mysqli_close($mysqli);
?>
