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
<?php
                    // Kiểm tra xem có từ khóa tìm kiếm không
if (isset($_GET['search']) || isset($_GET['category'])) {
    echo ' <div class="title">';
                        // Hiển thị từ khóa tìm kiếm
    if (isset($_GET['search'])) {

        echo '<span class="search-keyword">' . htmlspecialchars($_GET['search']) . '</span>';
    }

                        // Hiển thị từ khóa thể loại
    if (isset($_GET['category'])) {
        $selectedKeywords = array_map('htmlspecialchars', $_GET['category']);
        echo implode(', ', $selectedKeywords);
    }

    echo '</div>';
}
?>
<div class="wrapper flip">
    <div class="left">
        <?php
        // Truy vấn CSDL để lấy danh sách thể loại
        $query = "SELECT * FROM tbl_theloai";
        $result = $mysqli->query($query);

// Tạo mảng để chứa dữ liệu thể loại
        $theloaiArray = [];

// Kiểm tra và xử lý kết quả
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $theloaiArray[] = $row['tentheloai'];
            }
        }


        ?>
        <?php if (!empty($theloaiArray)): ?>
            
                <div class="title">Thể Loại</div>
                <?php foreach ($theloaiArray as $theloai) { ?>
                    <a class="disb menu box trai" href="index.php?quanly=truyen&category[]=<?php echo $theloai; ?>">
                        <?php echo $theloai; ?>
                    </a>
                <?php } ?>

            
        <?php else: ?>
            <p>Không có dữ liệu thể loại</p>
        <?php endif; ?>
    </div>
    <div class="right">
        <div class="container">


            <div class="list">

                <?php
                    // Thêm điều kiện WHERE để lọc theo thể loại nếu có
// Thêm điều kiện WHERE nếu có lựa chọn thể loại
                $whereClause = "";
                $count = "";
                $orderClause = "";
                $interClause = "";
                if (isset($_GET['category'])) {
                    $selectedCategories = array_map([$mysqli, 'real_escape_string'], $_GET['category']);
                    $categoryString = implode("','", $selectedCategories);
                    $whereClause = "WHERE theloai.tentheloai IN ('$categoryString')";
                }

                    // Thêm điều kiện WHERE cho tìm kiếm theo tên tác giả hoặc tiêu đề
                $searchTerm = isset($_GET['search']) ? $mysqli->real_escape_string($_GET['search']) : '';
                $whereClause .= " AND (truyen.tacgia LIKE '%$searchTerm%' OR truyen.tieude LIKE '%$searchTerm%')";

                    // Thêm điều kiện ORDER BY nếu có lựa chọn "Truyện mới" hoặc "Mới đăng"
                $orderClause = '';
                if (isset($_GET['moiCapNhat']) && $_GET['moiCapNhat'] == 'truyenMoi') {
                        // Nếu chọn "Truyện mới", sắp xếp theo ngày đăng của truyện
                    $orderClause = 'ORDER BY truyen.ngaydang DESC';
                } elseif (isset($_GET['moiCapNhat']) && $_GET['moiCapNhat'] == 'moiDang') {
                        // Nếu chọn "Mới đăng", sắp xếp theo thời gian của chương
                    $interClause = 'INNER JOIN
                    tbl_chuong chuong ON truyen.id_truyen = chuong.id_truyen';
                    $orderClause = 'ORDER BY MAX(tbl_chuong.thoigian) DESC';
                }
                $luotDocWhereClause = "";
                if (isset($_GET['like']) && $_GET['like'] == 'yeuthich') {
                        // Nếu chọn "Truyện mới", sắp xếp theo ngày đăng của truyện
                    $orderClause = 'ORDER BY truyen.yeuthich DESC';
                }
                    // Kiểm tra xem có lựa chọn lượt đọc không
                if (isset($_GET['luotDoc'])) {
                        // Lấy giá trị lượt đọc được chọn từ URL
                    $selectedLuotDoc = $_GET['luotDoc'];

                        // Dựa vào giá trị lựa chọn để tạo điều kiện WHERE tương ứng
                    switch ($selectedLuotDoc) {
                        case 'duoi1000':
                        $luotDocWhereClause = ' AND truyen.luotdoc < 1000';
                                $orderClause .= ' ORDER BY truyen.luotdoc DESC'; // Sắp xếp tăng dần (ASC)
                                break;
                                case '1000-100000':
                                $luotDocWhereClause = ' AND truyen.luotdoc >= 1000 AND truyen.luotdoc <= 100000';
                                $orderClause .= ' ORDER BY truyen.luotdoc DESC'; // Sắp xếp tăng dần (ASC)
                                break;
                                case 'tren100000':
                                $luotDocWhereClause = ' AND truyen.luotdoc > 100000';
                                $orderClause .= ' ORDER BY truyen.luotdoc DESC'; // Sắp xếp giảm dần (DESC)
                                break;
                                case 'all':
                                $luotDocWhereClause = ' AND truyen.luotdoc > 0';
                                $orderClause .= ' ORDER BY truyen.luotdoc DESC'; // Sắp xếp giảm dần (DESC)
                                break;
                            }
                        // Thêm các trường hợp khác nếu cần

                            $whereClause .= $luotDocWhereClause;
                        }
                        $decuWhereClause = "";

                    // Kiểm tra xem có lựa chọn đề cử không
                        if (isset($_GET['decu'])) {
                        // Lấy giá trị đề cử được chọn từ URL
                            $selectedDecu = $_GET['decu'];

                        // Dựa vào giá trị lựa chọn để tạo điều kiện WHERE tương ứng
                            switch ($selectedDecu) {
                                case 'duoi100':
                                $decuWhereClause = ' AND truyen.decu < 100';
                                $orderClause .= ' ORDER BY truyen.decu DESC';
                                break;
                                case '100-1000':
                                $decuWhereClause = ' AND truyen.decu >= 100 AND truyen.decu <= 1000';
                                $orderClause .= ' ORDER BY truyen.decu DESC';
                                break;
                                case '1000-5000':
                                $decuWhereClause = ' AND truyen.decu >= 1000 AND truyen.decu <= 5000';
                                $orderClause .= ' ORDER BY truyen.decu DESC';
                                break;
                                case 'tren5000':
                                $decuWhereClause = ' AND truyen.decu > 5000';
                                $orderClause .= ' ORDER BY truyen.decu DESC';
                                break;
                                case 'all':
                                $decuWhereClause = ' AND truyen.decu > 0';
                                // Nếu bạn muốn sắp xếp tất cả, thêm ORDER BY ở đây
                                $orderClause .= ' ORDER BY truyen.decu DESC';
                                break;

                            // Thêm các trường hợp khác nếu cần
                            }
                            $whereClause .= $decuWhereClause;
                        }
                        if (isset($_GET['truyen']) && $_GET['truyen'] == 'dangra') {
                        // Nếu chọn "Truyện mới", sắp xếp theo ngày đăng của truyện
                            $orderClause = ' ORDER BY truyen.ngaydang DESC';
                            $whereClause = ' AND truyen.status_tt = 0';
                        }

                        if (isset($_GET['truyen']) && $_GET['truyen'] == 'hoanthanh') {
                        // Nếu chọn "Truyện đã hoàn thành", sắp xếp theo ngày đăng của truyện
                            $orderClause = ' ORDER BY truyen.ngaydang DESC';
                            $whereClause = ' AND truyen.status_tt = 1';
                        }
                    // Kiểm tra xem có lựa chọn đề cử không


                        if (isset($_GET['binhluan']) && $_GET['binhluan'] == 'comment') {
                            $count = 'COALESCE(binhluan.tong_binhluan, 0) AS tong_binhluan,';
                            $interClause = '
                            LEFT JOIN (
                            SELECT 
                            id_truyen, 
                            COUNT(*) AS tong_binhluan
                            FROM 
                            tbl_binhluan
                            GROUP BY 
                            id_truyen
                            ) binhluan ON truyen.id_truyen = binhluan.id_truyen
                            ';
                            $orderClause = 'ORDER BY tong_binhluan DESC';
                        }

                        
                        $count = 'IFNULL(chuong.tong_chuong, 0) AS tong_chuong ,';
                        $interClause = 'LEFT JOIN (
                        SELECT
                        id_truyen,
                        COUNT(*) AS tong_chuong
                        FROM
                        tbl_chuong
                        GROUP BY
                        id_truyen
                    ) chuong ON truyen.id_truyen = chuong.id_truyen';
                    $orderClause = 'ORDER BY tong_chuong DESC';
                    

                    // Thêm điều kiện WHERE vào câu truy vấn chính
                    

                    // Thêm điều kiện WHERE vào câu truy vấn chính
                    

                    if (isset($_GET['danhgia'])) {
                        // Lấy giá trị đánh giá được chọn từ URL
                        $selectedDanhGia = $_GET['danhgia'];

                        // Dựa vào giá trị lựa chọn để tạo điều kiện HAVING tương ứng
                        switch ($selectedDanhGia) {
                            case 'duoi3':
                            $orderClause .= ' HAVING AVG(danhgia.diemtrungbinh) < 3 ORDER BY AVG(danhgia.diemtrungbinh) DESC';
                            break;
                            case '3-4':
                            $orderClause .= ' HAVING 
                            AVG(danhgia.diemtrungbinh) >= 3 AND AVG(danhgia.diemtrungbinh) <= 4 ORDER BY AVG(danhgia.diemtrungbinh) DESC';
                            break;
                            case '4-5':
                            $orderClause .= ' HAVING 
                            AVG(danhgia.diemtrungbinh) >= 4 AND AVG(danhgia.diemtrungbinh) <= 5 ORDER BY AVG(danhgia.diemtrungbinh) DESC';
                            break;
                            case 'all':
                            $orderClause .= ' HAVING AVG(danhgia.diemtrungbinh) >= 0 AND AVG(danhgia.diemtrungbinh) <= 5 ORDER BY AVG(danhgia.diemtrungbinh) DESC';
                            break;

                            // Thêm các trường hợp khác nếu cần
                        }

                        // Đảm bảo chỉ lấy những truyện có đánh giá
                        $whereClause .= ' WHERE 
                        danhgia.diemtrungbinh IS NOT NULL ';

                        $count = 'AVG(danhgia.diemtrungbinh) AS diemtrungbinh,';
                        $interClause = '
                        LEFT JOIN 
                        (
                        SELECT id_truyen, AVG(tongdiem) AS diemtrungbinh
                        FROM tbl_danhgia
                        GROUP BY id_truyen
                    ) danhgia ON truyen.id_truyen = danhgia.id_truyen';
                }
                    // Thực hiện truy vấn SQL
                $truyenPerPage = 18;

// Trang hiện tại, mặc định là trang 1 nếu không có giá trị
                $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Tính OFFSET dựa trên trang hiện tại và số truyện trên mỗi trang
                $offset = ($current_page - 1) * $truyenPerPage;
                $sql = "SELECT
                truyen.status_tt,
                truyen.id_truyen,
                truyen.tieude,
                truyen.tomtat,
                truyen.hinhanh,
                truyen.luotdoc,
                truyen.decu,
                truyen.yeuthich,
                truyen.tacgia AS tacgia,
                $count
                MAX(theloai.tentheloai) AS theloai
                FROM
                tbl_truyen truyen
                INNER JOIN
                tbl_admin admin ON truyen.id_admin = admin.id_admin
                INNER JOIN
                tbl_truyen_theloai tt ON truyen.id_truyen = tt.id_truyen
                INNER JOIN
                tbl_theloai theloai ON tt.id_theloai = theloai.id_theloai
                $interClause
                $whereClause
                GROUP BY
                truyen.id_truyen
                $orderClause
                LIMIT $offset, $truyenPerPage;";

                $result = $mysqli->query($sql);
                ?>


                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="box">
                        <div class="thumb">
                            <a href="index.php?quanly=thongtintruyen&id_truyen=<?php echo $row['id_truyen']; ?>">
                                <img src="./admin/modules/quanlytruyen/uploads/<?php echo $row['hinhanh']; ?>" alt="Truyện <?php echo $row['tieude'];
                                ; ?>" class="ithumb">
                            </a>
                        </div>
                        <div class="info-list">
                            <div class="list-name">
                                <a href="index.php?quanly=thongtintruyen&id_truyen=<?php echo $row['id_truyen']; ?>"><h3><?php echo $row['tieude'];
                                ; ?></h3></a>
                            </div>
                            <div class="list-time">
                                Tác giả: <a href="index.php?quanly=truyen&search=<?php echo  $row['tacgia']; ?>" class="theloai321"><?php echo $row['tacgia']; ?></a>
                                <br>    
                                📚 <?php echo $row['tong_chuong']; ?> chương
                                <br>    
                                Tình trạng: <?php
                                if($row['status_tt']==0) {
                                    echo 'Chưa hoàn thành';
                                } else if($row['status_tt']==1){
                                    echo '<b>Hoàn Thành</b>';
                                } else {
                                    echo '<i>Không đọc được</i>';
                                }
                                ?>
                            </div>
                            <!--div class="mota"><?php //echo $row['tomtat']; ?></div-->
                        </div>
                    </div>



                <?php endwhile; ?>
            </div>
            <hr>    
            <div class="pagination">
                <?php
    // Tính tổng số truyện dựa trên điều kiện lọc
                $count_sql = "SELECT COUNT(DISTINCT truyen.id_truyen) AS total FROM tbl_truyen truyen INNER JOIN tbl_truyen_theloai tt ON truyen.id_truyen = tt.id_truyen INNER JOIN tbl_theloai theloai ON tt.id_theloai = theloai.id_theloai $interClause $whereClause";
                $count_result = $mysqli->query($count_sql);
                $row = $count_result->fetch_assoc();
                $total_truyen = $row['total'];

    // Tính tổng số trang
                $total_pages = ceil($total_truyen / $truyenPerPage);

    // Hiển thị nút phân trang
                for ($i = 1; $i <= $total_pages; $i++) {
                    $activeClass = ($i == $current_page) ? 'box nav-sub' : '';
        $filterParams = $_GET; // Lấy các tham số lọc từ URL
        $filterParams['page'] = $i; // Thêm tham số page vào mảng
        $pageLink = "index.php?" . http_build_query($filterParams); // Tạo URL từ mảng tham số
        echo "<a class='btn $activeClass' href='$pageLink'>$i</a>";
    }
    ?>
</div>



</div>
</div>
</div>
