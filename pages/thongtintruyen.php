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
if (isset($_GET['id_truyen'])) {
    // Lấy giá trị id_truyen từ URL
    $id_truyen = $_GET['id_truyen'];
    $queryUpdateLuotDoc = "UPDATE tbl_truyen SET luotdoc = luotdoc + 1 WHERE id_truyen = $id_truyen";
    $resultUpdateLuotDoc = $mysqli->query($queryUpdateLuotDoc);
}
    // Thực hiện câu truy vấn để lấy dữ liệu từ cơ sở dữ liệu
$query = "SELECT 
truyen.id_truyen,
truyen.tieude,
truyen.hinhanh,
truyen.tomtat,
truyen.ngaydang,
truyen.tacgia,
truyen.yeuthich,
truyen.luotdoc,
truyen.status_tt,
truyen.decu,
admin.id_admin,
admin.ten AS tentacgia,
GROUP_CONCAT(DISTINCT theloai.tentheloai ORDER BY theloai.thutu ASC) AS danh_sach_theloai,
COUNT(DISTINCT chuong.id_chuong) AS tongchuong
FROM
tbl_truyen truyen
INNER JOIN
tbl_admin admin ON truyen.id_admin = admin.id_admin
INNER JOIN
tbl_truyen_theloai tt ON truyen.id_truyen = tt.id_truyen
INNER JOIN
tbl_theloai theloai ON tt.id_theloai = theloai.id_theloai
LEFT JOIN 
tbl_chuong chuong ON truyen.id_truyen = chuong.id_truyen
WHERE
truyen.id_truyen = $id_truyen
GROUP BY
truyen.id_truyen,
truyen.tieude,
truyen.hinhanh,
truyen.tomtat,
truyen.ngaydang,
admin.id_admin,
admin.ten
ORDER BY
truyen.ngaydang DESC;

";

    // Thực hiện truy vấn và lấy dữ liệu
$result = $mysqli->query($query);

    // Kiểm tra và hiển thị dữ liệu
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="title"><h3><?php echo $row['tieude']; ?></h3></div>
        <div class="wrapper">
            <div class="left">
                <div id="#folders" class="list">
                    <div class="box">
                        <div class="thumb">
                            <a href="index.php?quanly=thongtintruyen&id_truyen=<?php echo $row['id_truyen']; ?>">
                                <img src="./admin/modules/quanlytruyen/uploads/<?php echo $row['hinhanh']; ?>" alt="Truyện <?php echo $row['tieude']; ?>" class="ithumb">
                            </a>
                        </div>
                        <div class="info-list">
                            <div class="list-time">
                                Tác giả: <a href="index.php?quanly=truyen&search=<?php echo urlencode($row['tacgia']); ?>"><?php echo $row['tacgia']; ?></a><br>
                                Thể loại: 
                                <?php
                                $arrTheloai = explode(',', $row['danh_sach_theloai']);


                                foreach ($arrTheloai as $theloai) {
                                    echo '<a href="index.php?quanly=truyen&category[]=' . trim($theloai) . '" class="theloai231">';
                                    echo '' . trim($theloai) . '';
                                    echo'</a>, ';
                                } ?>

                            </div>
                            <?php

                            function formatNumber($number) {
                                if ($number > 1000000) {

                                    return round($number / 1000000, 1) . 'M';
                                } elseif ($number > 10000) {
                                    return round($number / 1000, 1) . 'k';
                                } else {
                                    return $number;
                                }
                            }

                            ?>
                            <div class="trai menu chunho">
                                Lượt đọc: <?php echo formatNumber($row['luotdoc']); ?>
                                <br>
                                Số Chương: <?php echo formatNumber($row['tongchuong']); ?> Chương</span>
                                <br>    
                                Trạng thái: <?php if ($row['status_tt'] == 1) {
                                    echo 'Hoàn thành';
                                } else {
                                    echo 'Đang ra';
                                } ?>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <?php
// ... (mã PHP hiện tại của bạn)

// Truy vấn lấy id_chuong cho truyện có sochuong=1
                        $queryChuongSo1 = "
                        SELECT id_chuong
                        FROM tbl_chuong
                        WHERE id_truyen = $id_truyen AND sochuong = 1
                        LIMIT 1;
                        ";

// Thực hiện truy vấn và lấy dữ liệu
                        $resultChuongSo1 = $mysqli->query($queryChuongSo1);

// Kiểm tra và hiển thị nút "Đọc Từ Đầu"
                        if ($resultChuongSo1 && $resultChuongSo1->num_rows > 0) {
                            $rowChuongSo1 = $resultChuongSo1->fetch_assoc();
                            $id_chuong_so1 = $rowChuongSo1['id_chuong'];

    // Hiển thị nút "Đọc Từ Đầu" với id_chuong tương ứng
                            echo '<a href="index.php?quanly=doc&id_truyen=' . $id_truyen . '&id_chuong=' . ($id_chuong_so1 ) . '" class="menu"><i class="fa-solid fa-glasses"></i> Đọc Từ Đầu</a>';
                        } else {
                            echo '<p>Không có chương nào</p>';
                        }

// ... (mã PHP hiện tại của bạn tiếp tục)
                        ?>
                        <?php

// Kết nối đến CSDL (Giả sử bạn đã kết nối rồi)
// ...

                        if (isset($_SESSION['id_user'])) {
                            $id_user = $_SESSION['id_user'];

    // Lấy thông tin từ CSDL về truyện đã đọc của người dùng
                            $query_read_story = "SELECT 
                            truyen.id_truyen, 
                            truyen.tieude, 
                            truyen.hinhanh, 
                            MAX(chuong.sochuong) AS tong_so_chuong,
                            chuong_doc.id_chuong AS id_chuong_doc,
                            chuong_doc.sochuong AS so_chuong_doc
                            FROM 
                            tbl_truyen AS truyen
                            LEFT JOIN 
                            tbl_reading_status AS reading ON reading.id_truyen = truyen.id_truyen
                            LEFT JOIN 
                            tbl_chuong AS chuong ON truyen.id_truyen = chuong.id_truyen
                            LEFT JOIN 
                            tbl_chuong AS chuong_doc ON reading.id_chuong = chuong_doc.id_chuong
                            WHERE 
                            reading.id_user = $id_user AND truyen.id_truyen = $id_truyen
                            GROUP BY 
                            truyen.id_truyen, truyen.tieude, truyen.hinhanh, id_chuong_doc, so_chuong_doc
                            ";
                            $result_read_story = mysqli_query($mysqli, $query_read_story);

    // Kiểm tra và hiển thị thông tin truyện đã đọc
                            if ($result_read_story && mysqli_num_rows($result_read_story) > 0) {
                                $row_story = mysqli_fetch_assoc($result_read_story);
                                ?>
                                <a href="index.php?quanly=doc&id_truyen=<?php echo $row_story['id_truyen']; ?>&id_chuong=<?php echo $row_story['id_chuong_doc']; ?>" class="menu">Đọc tiếp</a>

                                <?php
                            }
                        } elseif (isset($_COOKIE['user_id'])) {
    // Code xử lý cookie tương tự như trên (nếu cần)
                        }
                        ?>
                        <a href="#chonchuong" class="menu">Chọn Chương</a>
                    </div>
                </div>
                
                <div class="box container disb trai chunho">
                    <?php echo nl2br($row['tomtat']); ?>

                </div>

            </div>
            <div class="right">
                <?php

            // Truy vấn lấy thông tin giới thiệu và số chương
                $queryInfoAndChapter = "SELECT 
                truyen.id_truyen,
                truyen.tieude,
                truyen.hinhanh,
                truyen.tomtat,
                truyen.ngaydang,
                admin.id_admin,
                admin.ten AS tentacgia,
                theloai.tentheloai,
                COUNT(chuong.id_chuong) AS sochuong
                FROM
                tbl_truyen truyen
                INNER JOIN
                tbl_admin admin ON truyen.id_admin = admin.id_admin
                INNER JOIN
                tbl_truyen_theloai tt ON truyen.id_truyen = tt.id_truyen
                INNER JOIN
                tbl_theloai theloai ON tt.id_theloai = theloai.id_theloai
                LEFT JOIN
                tbl_chuong chuong ON truyen.id_truyen = chuong.id_truyen
                WHERE
                truyen.id_truyen = $id_truyen
                GROUP BY
                truyen.id_truyen,
                truyen.tieude,
                truyen.hinhanh,
                truyen.tomtat,
                truyen.ngaydang,
                admin.id_admin,
                admin.ten,
                theloai.tentheloai
                ORDER BY
                truyen.ngaydang DESC
                LIMIT 1;
                ";

            // Thực hiện truy vấn và lấy dữ liệu
                $resultInfoAndChapter = $mysqli->query($queryInfoAndChapter);

            // Kiểm tra và hiển thị thông tin giới thiệu và số chương

                $queryChuong = "SELECT 
                chuong.sochuong,
                chuong.tenchuong,
                chuong.id_chuong  -- Thêm trường id_chuong vào câu truy vấn
                FROM
                tbl_chuong chuong
                WHERE
                chuong.id_truyen = $id_truyen
                ORDER BY
                chuong.sochuong;
                ";

// Thực hiện truy vấn và lấy dữ liệu
                $resultChuong = $mysqli->query($queryChuong);

// Kiểm tra và hiển thị danh sách chương
                if ($resultChuong && $resultChuong->num_rows > 0) {
                    echo '<div class="list disb trai" id="chonchuong">';
                    
                    while ($rowChuong = $resultChuong->fetch_assoc()) {
                        $id_chuong = $rowChuong['id_chuong'];
                        echo '<a href="index.php?quanly=doc&id_truyen=' . $id_truyen . '&id_chuong=' . $id_chuong . '" class="btn disb box trai">' . 'Chương ' . $rowChuong['sochuong'] . ': ' . $rowChuong['tenchuong'] . '</a>';
                    }
                    echo '</div>';
                } else {
                    echo '<div class="tab-pane fade" id="chonchuong">';
                    echo '<h3 class="h3-acd">Danh Sách Chương</h3>';
                    echo '<p class="p-acd">Không có chương nào.</p>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        <?php }} ?>