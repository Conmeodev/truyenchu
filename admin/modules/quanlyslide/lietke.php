<div class="container-fluid">
    <div class="row">
        <!-- Cột bên trái -->
        <div class="col-md-3 left-column">
            <h2>Danh sách Ảnh Trang Bìa</h2>
            <?php
            // Lấy danh sách ảnh trang bìa từ cơ sở dữ liệu và sắp xếp theo thutu
            $sql_anhtrangbia = "SELECT * FROM tbl_anhtrangbia ORDER BY thutu ASC";
            $result_anhtrangbia = $mysqli->query($sql_anhtrangbia);

            if ($result_anhtrangbia->num_rows > 0) {
                echo "<ul class='list-group'>";
                while ($row_anhtrangbia = $result_anhtrangbia->fetch_assoc()) {
                    $trangThai = ($row_anhtrangbia['tinhtrang'] == 1) ? 'Hiển thị' : 'Ẩn';
                    echo "<li class='list-group-item'>
                            <img src='modules/quanlyslide/uploads/{$row_anhtrangbia['hinhanh']}' alt='Ảnh Trang Bìa' class='img-thumbnail'>
                            <span class='float-left'>
                                <p>Trạng thái: $trangThai</p>
                                <p>Thứ tự: {$row_anhtrangbia['thutu']}</p>
                                <a href='index.php?action=quanlyslide&query=xuly&id_anhtrangbia={$row_anhtrangbia['id_anhtrangbia']}' class='btn btn-danger btn-sm' onclick='return confirmDelete()'>Xóa</a>
                                <a href='index.php?action=quanlyslide&query=sua&id_anhtrangbia={$row_anhtrangbia['id_anhtrangbia']}' class='btn btn-warning btn-sm'>Sửa</a>
                            </span>
                          </li>";
                }
                echo "</ul>";
            } else {
                echo "Không có ảnh trang bìa nào trong cơ sở dữ liệu.";
            }
            ?>
        </div>

        <!-- Cột bên phải -->
        <?php include("them.php"); ?>
    </div>
</div>
<script>
    function confirmDelete() {
        return confirm("Bạn có chắc chắn muốn xóa bìa này không?");
    }
</script>