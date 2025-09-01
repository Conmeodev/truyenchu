<?php
// Kết nối đến CSDL (Giả sử bạn đã kết nối rồi)
// ...

// Lấy thông tin từ form hoặc các biến khác
$id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;
$id_truyen = isset($_GET['id_truyen']) ? $_GET['id_truyen'] : null;
$id_chuong = isset($_GET['id_chuong']) ? $_GET['id_chuong'] : null;

// Kiểm tra xem đã có bản ghi cho người dùng, truyện và chưa
if ($id_user !== null && $id_truyen !== null && $id_chuong !== null) {
    $query_check = "SELECT id FROM tbl_reading_status WHERE id_user = $id_user AND id_truyen = $id_truyen";
    $result_check = mysqli_query($mysqli, $query_check);

    if ($result_check && mysqli_num_rows($result_check) > 0) {
        // Nếu đã tồn tại, cập nhật chỉ id_chuong
        $query_update = "UPDATE tbl_reading_status SET id_chuong = $id_chuong WHERE id_user = $id_user AND id_truyen = $id_truyen";
        mysqli_query($mysqli, $query_update);
    } else {
        // Nếu chưa tồn tại, thêm mới bản ghi
        $query_insert = "INSERT INTO tbl_reading_status (id_user, id_truyen, id_chuong) VALUES ($id_user, $id_truyen, $id_chuong)";
        mysqli_query($mysqli, $query_insert);
    }
}

// Lưu vào cookie nếu có id_user
if ($id_user !== null) {
    $cookie_name = "user_id";
    $cookie_value = $id_user;
    $expire = time() + (30 * 24 * 60 * 60); // Hết hạn sau 30 ngày
    setcookie($cookie_name, $cookie_value, $expire, "/");
}

if (isset($_GET['id_truyen']) && isset($_GET['id_chuong'])) {
    // Lấy giá trị id_truyen và id_chuong từ URL
    $id_truyen = $_GET['id_truyen'];
    $id_chuong = $_GET['id_chuong'];
}

// Truy vấn lấy thông tin về truyện và chương
$query = "
SELECT 
truyen.id_truyen,
truyen.tieude,
chuong.id_chuong,
chuong.tenchuong,
chuong.noidung,
chuong.sochuong
FROM
tbl_truyen truyen
INNER JOIN
tbl_chuong chuong ON truyen.id_truyen = chuong.id_truyen
WHERE
truyen.id_truyen = $id_truyen AND chuong.id_chuong = $id_chuong
LIMIT 1;
";

// Thực hiện truy vấn và lấy dữ liệu
$result = $mysqli->query($query);
?>

<div class="container">
    <div class="contents-container">
        <?php if ($result && $result->num_rows > 0): 
            $row = $result->fetch_assoc();
            // Truy vấn lấy danh sách chương
            $queryChapters = "
            SELECT id_chuong, tenchuong, sochuong
            FROM tbl_chuong
            WHERE id_truyen = {$row['id_truyen']}
            ORDER BY sochuong;
            ";
            $resultChapters = $mysqli->query($queryChapters);
            ?>
            <div class="title"> 
                <a class="tentieude" href="index.php?quanly=thongtintruyen&id_truyen=<?php echo $row['id_truyen']; ?>">
                    <?php echo $row['tieude']; ?>
                </a>
            </div>
            <div class="center">
                <div class="flex center">
                    <?php if ($row['sochuong'] > 1): 
                        $prevChapterNumber = $row['sochuong'] - 1;
                        $queryPrevChapter = "
                        SELECT id_chuong
                        FROM tbl_chuong
                        WHERE id_truyen = {$row['id_truyen']} AND sochuong = $prevChapterNumber
                        ";
                        $resultPrevChapter = $mysqli->query($queryPrevChapter);
                        $rowPrevChapter = $resultPrevChapter->fetch_assoc();
                        ?>
                        <a class="btn" href="index.php?quanly=doc&id_truyen=<?php echo $row['id_truyen']; ?>&id_chuong=<?php echo $rowPrevChapter['id_chuong']; ?>">
                            <i class='fas fa-arrow-left'></i>◀️ Chương Trước
                        </a>
                    <?php endif; ?>

                    <?php 
                    $nextChapterNumber = $row['sochuong'] + 1;
                    $queryNextChapter = "
                    SELECT id_chuong
                    FROM tbl_chuong
                    WHERE id_truyen = {$row['id_truyen']} AND sochuong = $nextChapterNumber
                    ";
                    $resultNextChapter = $mysqli->query($queryNextChapter);
                    $rowNextChapter = $resultNextChapter->fetch_assoc();
                    if ($rowNextChapter): ?>
                        <a class="btn" href="index.php?quanly=doc&id_truyen=<?php echo $row['id_truyen']; ?>&id_chuong=<?php echo $rowNextChapter['id_chuong']; ?>">
                            Chương Sau ▶️
                        </a>
                    <?php endif; ?>

                </div>
                <?php if ($resultChapters && $resultChapters->num_rows > 0): 
                    $soChuongDangDoc = isset($_GET['id_chuong']) ? $_GET['id_chuong'] : '';
                    ?>
                    <select class="menu box disi max-w-select" id="chapter-list" onchange="truyendangdoc()">
                        <?php while ($chapter = $resultChapters->fetch_assoc()): 
                            $selected = ($chapter['id_chuong'] == $soChuongDangDoc) ? 'selected' : '';
                            $class = ($chapter['id_chuong'] == $soChuongDangDoc) ? 'selected-option' : 'normal-option';
                            ?>
                            <option value="<?php echo $chapter['id_chuong']; ?>" <?php echo $selected; ?> class="<?php echo $class; ?>">
                                Chương <?php echo $chapter['sochuong']; ?>: <?php echo $chapter['tenchuong']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                <?php else: ?>
                    <p>Chưa có chương nào.</p>
                <?php endif; ?>

                <br>    
                <br><h3>Chương <span class="chuonghientai"><?php echo $row['sochuong']; ?></span>: <?php echo $row['tenchuong']; ?></h3><hr>   
            </div>

            <div class="pad">
                <p class="content-text"><?php echo nl2br($row['noidung']); ?></p>
            </div>
            <br>    
            <hr>
            <div class="center">
                <?php if ($row['sochuong'] > 1): ?>
                    <a class="btn" href="index.php?quanly=doc&id_truyen=<?php echo $row['id_truyen']; ?>&id_chuong=<?php echo $rowPrevChapter['id_chuong']; ?>">
                        ◀️ Chương Trước
                    </a>
                <?php endif; ?>
                <?php if ($rowNextChapter): ?>
                    <a class="btn" href="index.php?quanly=doc&id_truyen=<?php echo $row['id_truyen']; ?>&id_chuong=<?php echo $rowNextChapter['id_chuong']; ?>">
                        Chương Sau ▶️
                    </a>
                <?php endif; ?>

            </div>
        <?php else: ?>
            <p>Không có dữ liệu.</p>
        <?php endif; ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
        document.cookie = name + "=" + (value || "") + expires + "; path=/; secure"; // Thêm secure nếu sử dụng HTTPS
    }

    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    function applySettings() {
        var fontSize = getCookie('fontSize');
        var fontFamily = getCookie('fontFamily');
        var lineHeight = getCookie('lineHeight');
        var backgroundColor = getCookie('backgroundColor');

        if (fontSize) {
            $('#fontsize').val(fontSize).change();
        }

        if (fontFamily) {
            $('#fontfamily').val(fontFamily).change();
        }

        if (lineHeight) {
            $('#lineheight').val(lineHeight).change();
        }

        if (backgroundColor) {
            $('#backgroundcolor').val(backgroundColor).change();
        }
    }

    applySettings();

    $('#fontsize').change(function() {
        var fontSize = $(this).val();
        $('p.content-text').css('font-size', fontSize + 'px');
        setCookie('fontSize', fontSize, 30);
    });

    $('#fontfamily').change(function() {
        var fontFamily = $(this).val();
        $('.chapter-content').css('font-family', fontFamily);
        setCookie('fontFamily', fontFamily, 30);
    });

    $('#lineheight').change(function() {
        var lineHeight = $(this).val();
        $('.chapter-content').css('line-height', lineHeight);
        setCookie('lineHeight', lineHeight, 30);
    });

    $('#backgroundcolor').change(function() {
        var backgroundColor = $(this).val();
        $('.chapter-info').css('background-color', backgroundColor);
        setCookie('backgroundColor', backgroundColor, 30);
    });
});

</script>

<script>
    function truyendangdoc(){
        document.addEventListener("DOMContentLoaded", function() {
    // Lấy tham số URL
            const params = new URLSearchParams(window.location.search);
            const idTruyen = params.get("id_truyen");
            const idChuong = document.querySelector(".chuonghientai")?.textContent.trim();

    // Nếu có id_truyen và id_chuong thì lưu
            if (idTruyen && idChuong) {
        // Lấy danh sách hiện tại từ localStorage (nếu có)
                let dangDoc = JSON.parse(localStorage.getItem("dangDoc")) || [];

        // Kiểm tra truyện đã có chưa
                const index = dangDoc.findIndex(t => t.id_truyen == idTruyen);

                if (index >= 0) {
            // Cập nhật chương mới
                    dangDoc[index].id_chuong = idChuong;
                } else {
            // Lấy tên truyện từ trang (thay ".ten-truyen" bằng selector thực tế của bạn)
                    const tenTruyen = document.querySelector(".tentieude")?.textContent.trim() || "Truyện " + idTruyen;

            // Thêm truyện mới vào danh sách
                    dangDoc.push({
                        id_truyen: idTruyen,
                        id_chuong: idChuong,
                        ten_truyen: tenTruyen
                    });
                }

        // Lưu lại vào localStorage
                localStorage.setItem("dangDoc", JSON.stringify(dangDoc));
            }
        });
    }
    truyendangdoc();
</script>


