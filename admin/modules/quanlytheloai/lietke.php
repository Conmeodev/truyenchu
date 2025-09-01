<div class="container-fluid">
    <div class="row">
        <!-- Cột bên trái -->
        <div class="col-md-3 left-column">
            <h2>Danh sách Thể loại</h2>
            <?php
            // Lấy danh sách thể loại từ cơ sở dữ liệu và sắp xếp theo thutu
            $sql_theloai = "SELECT * FROM tbl_theloai ORDER BY thutu ASC";
            $result_theloai = $mysqli->query($sql_theloai);

            if ($result_theloai->num_rows > 0) {
                echo "<ul class='list-group'>";
                while ($row_theloai = $result_theloai->fetch_assoc()) {
                    echo "<li class='list-group-item'>
                                 {$row_theloai['thutu']} - {$row_theloai['tentheloai']}
                                <span class='float-right'>
                                <a href='#' onclick='confirmDelete({$row_theloai['id_theloai']});' class='btn btn-danger btn-sm'>Xóa</a>
                                <a href='index.php?action=quanlytheloai&query=sua&id_theloai={$row_theloai['id_theloai']}' class='btn btn-warning btn-sm'>Sửa</a>
                                </span>
                              </li>";
                }
                echo "</ul>";
            } else {
                echo "Không có thể loại nào trong cơ sở dữ liệu.";
            }
            ?>
        </div>

        <!-- Cột bên phải -->
        <?php include("them.php"); ?>
        <script>
            function confirmDelete(id_theloai) {
                var confirmation = confirm('Bạn có muốn xóa thể loại này không?');

                if (confirmation) {
                    // Người dùng đã ấn OK, thực hiện hành động xóa
                    window.location.href = 'index.php?action=quanlytheloai&query=xuly&id_theloai=' + id_theloai;
                } else {
                    // Người dùng đã ấn Cancel, không thực hiện gì cả
                }
            }
        </script>
