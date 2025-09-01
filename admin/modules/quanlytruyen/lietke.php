<?php

// Lấy danh sách truyện từ cơ sở dữ liệu
$id_admin_tuong_ung = $_SESSION['id_admin']; // Thay thế bằng id_admin tương ứng
$role_id_tuong_ung = $_SESSION['role_id']; // Thay thế bằng role_id tương ứng
$truyenPerPage = 20; // Số truyện hiển thị trên mỗi trang
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $truyenPerPage;

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Tạo đường dẫn cho form tìm kiếm
$searchFormAction = "index.php?action=quanlytruyen&query=lietke";

$sql = "SELECT tbl_truyen.*, GROUP_CONCAT(tbl_theloai.tentheloai ORDER BY tbl_theloai.thutu SEPARATOR ', ') AS theloai, COALESCE(chuong_count.sochuong, 0) AS sochuong
        FROM tbl_truyen
        LEFT JOIN tbl_truyen_theloai ON tbl_truyen.id_truyen = tbl_truyen_theloai.id_truyen
        LEFT JOIN tbl_theloai ON tbl_truyen_theloai.id_theloai = tbl_theloai.id_theloai
        LEFT JOIN (
            SELECT id_truyen, COUNT(id_chuong) AS sochuong
            FROM tbl_chuong
            GROUP BY id_truyen
        ) AS chuong_count ON tbl_truyen.id_truyen = chuong_count.id_truyen
        WHERE ($role_id_tuong_ung = 1 OR tbl_truyen.id_admin = $id_admin_tuong_ung)
            AND (tbl_truyen.tieude LIKE '%$searchTerm%' OR tbl_theloai.tentheloai LIKE '%$searchTerm%' OR chuong_count.sochuong LIKE '%$searchTerm%')
        GROUP BY tbl_truyen.id_truyen
        ORDER BY tbl_truyen.id_truyen DESC
        LIMIT $offset, $truyenPerPage";

$result = $mysqli->query($sql);
$totalRows = $result->num_rows;
$totalPages = ceil($totalRows / $truyenPerPage);
?>

<div class="container mt-4">
    <h2>Danh Sách Truyện</h2>

    <!-- Form tìm kiếm -->
<!-- Thêm vào nơi bạn muốn hiển thị ô tìm kiếm và nút tìm kiếm -->
<form action="index.php" method="get" class="form-inline mt-2 mb-2">
    <input type="hidden" name="action" value="quanlytruyen">
    <input type="hidden" name="query" value="lietke">
    <input type="hidden" name="page" value="1"> <!-- Để đảm bảo page không bị trống -->
    <input type="text" name="search" class="form-control mr-2" placeholder="Tìm kiếm">
    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
</form>


    <?php
    if ($result->num_rows > 0) {
    ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Ảnh</th>
                    <th>Tên truyện</th>
                    <th>Thể loại</th>
                    <th>Số Chương</th>
                    <th>Tác giả</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stt = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>$stt</td>
                            <td><img src='modules/quanlytruyen/uploads/{$row['hinhanh']}' alt='Ảnh truyện' width='50'></td>
                            <td>{$row['tieude']}</td>
                            <td>{$row['theloai']}</td>
                            <td>{$row['sochuong']}</td>
                            <td>{$row['tacgia']}</td>
                            <td>
                                <a href='index.php?action=quanlytruyen&query=themchuong&id_truyen={$row['id_truyen']}' class='btn btn-primary btn-sm'>Chương mới</a>
                                <a href='index.php?action=quanlytruyen&query=sua&id_truyen={$row['id_truyen']}' class='btn btn-warning btn-sm'>Sửa</a>
                                <a href='#' onclick='confirmDelete({$row['id_truyen']})' class='btn btn-danger btn-sm'>Xóa</a>                            </td>
                          </tr>";

                    $stt++;
                }
                ?>
            </tbody>
        </table>
    <?php
    } else {
        echo "Không có truyện nào trong cơ sở dữ liệu.";
    }
    ?>
<nav aria-label="Page navigation">
    <ul class="pagination">
        <?php
        // Display Previous Page link
        if ($page > 1) {
            echo "<li class='page-item'><a class='page-link' href='index.php?action=quanlytruyen&query=lietke&page=" . ($page - 1) . "&search=$searchTerm'>&laquo; Previous</a></li>";
        }

        // Display numbered page links
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='index.php?action=quanlytruyen&query=lietke&page=$i&search=$searchTerm'>$i</a></li>";
        }

        // Display Next Page link
        if ($page < $totalPages) {
            echo "<li class='page-item'><a class='page-link' href='index.php?action=quanlytruyen&query=lietke&page=" . ($page + 1) . "&search=$searchTerm'>Next &raquo;</a></li>";
        }
        ?>
    </ul>
</nav>

</div>

<?php
$mysqli->close();
?>
<script>
function confirmDelete(id_truyen) {
    var result = confirm("Bạn có chắc muốn xóa truyện này không?");
    if (result) {
        // Nếu người dùng chọn "OK", chuyển hướng đến trang xử lý xóa
        window.location.href = 'index.php?action=quanlytruyen&query=xuly&id_truyen=' + id_truyen;
    } else {
        // Nếu người dùng chọn "Cancel", không làm gì cả
    }
}
</script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
