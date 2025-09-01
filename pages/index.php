<?php
include('./admin/config/config.php');

$sql = "SELECT hinhanh FROM tbl_anhtrangbia WHERE tinhtrang = 1 ORDER BY RAND() LIMIT 1";
$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $imagePath = './admin/modules/quanlyslide/uploads/' . $row['hinhanh'];
} else {

    $imagePath = '../admin/modules/quanlyslide/uploads/bia1.webp';
}
?>

<!-- Thẻ img cho hiển thị ảnh -->
<img class="top-bg-op-box" src="<?php echo $imagePath; ?>" alt="Background Image">
<div class="container">
    <div class="title">Truyện Mới Cập Nhật</div>
    <?php

    function time_elapsed_string($datetime) {

        $timezone = new DateTimeZone('Asia/Ho_Chi_Minh');

        $now = new DateTime('now', $timezone);

        $ago = new DateTime($datetime);

        $diff = $now->diff($ago);

        $diff_str = [
            'y' => 'năm',
            'm' => 'tháng',
            'd' => 'ngày',
            'h' => 'giờ',
            'i' => 'phút',
            's' => 'giây',
        ];

        foreach ($diff_str as $key => &$value) {
            if ($diff->$key) {
                $value = $diff->$key . ' ' . $value . ($diff->$key > 1 ? '' : '');
                return ($key == 's') ? 'vừa xong' : $value . ' trước';
            }
        }

        return 'vừa xong';
    }

    $query = "SELECT
    truyen.id_truyen,
    truyen.hinhanh,
    MAX(theloai.tentheloai) AS tentheloai,
    truyen.tieude AS tentruyen,
    MAX(chuong.id_chuong) AS id_chuong,
    MAX(chuong.sochuong) AS sochuong,
    MAX(chuong.tenchuong) AS tenchuong,
    MAX(admin.ten) AS tacgia,
    MAX(chuong.thoigian) AS thoigian
    FROM
    tbl_chuong chuong
    INNER JOIN
    tbl_truyen truyen ON chuong.id_truyen = truyen.id_truyen
    INNER JOIN
    tbl_admin admin ON truyen.id_admin = admin.id_admin
    INNER JOIN
    tbl_truyen_theloai tt ON truyen.id_truyen = tt.id_truyen
    INNER JOIN
    tbl_theloai theloai ON tt.id_theloai = theloai.id_theloai
    GROUP BY
    truyen.id_truyen
    ORDER BY
    MAX(chuong.thoigian) DESC
    LIMIT 18";

    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        ?>

        <div id="#files" _ad class="block">
            <?php
            while ($row = $result->fetch_assoc()) {
                ?>
                <a class="box" href="index.php?quanly=thongtintruyen&id_truyen=<?php echo $row['id_truyen']; ?>&id_chuong=<?php echo $row['id_chuong']; ?>">
                 <div class="thumb">
                    <div class="box-type">Chương <?php echo $row['sochuong']; ?></div>
                    <img src="./admin/modules/quanlytruyen/uploads/<?php echo $row['hinhanh']; ?>" alt="" class="ithumb">
                </div>
                <div class="info-list">
                    <div class="list-name"><?php echo $row['tentruyen']; ?></div>
                </div>
            </a>
            <?php
        }
        ?>

    </div>
    <?php
} else {
    echo "Không có dữ liệu.";
}
?>

</div>
</div>
<div class="wrapper">
    <div class="left">
        <div class="container">
            <div class="title">Đang Đọc</div>
            <div class="container">
                <div id="dang-doc-list"></div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const listContainer = document.getElementById("dang-doc-list");
                    let dangDoc = JSON.parse(localStorage.getItem("dangDoc")) || [];

                    function renderList() {
                        listContainer.innerHTML = "";
                        dangDoc.forEach((t, index) => {
                            const item = document.createElement("div");
                            item.className = "menu mota";
                            item.innerHTML = `
                <a href="index.php?quanly=doc&id_truyen=${t.id_truyen}&id_chuong=${t.id_chuong}">
                    ${t.ten_truyen} | chap ${t.id_chuong}
                </a>
                <button class="xoa" style="margin-left:10px;color:red;cursor:pointer;">x</button>
                            `;
            // Xóa truyện khi bấm nút
                            item.querySelector(".xoa").addEventListener("click", function() {
                                dangDoc.splice(index, 1);
                                localStorage.setItem("dangDoc", JSON.stringify(dangDoc));
                                renderList();
                            });
                            listContainer.appendChild(item);
                        });
                    }

                    renderList();
                });
            </script>

        </div>
        <div class="container">
            <div class="title">Truyện Đề Cử</div>
            <?php
            $sql = "SELECT
            truyen.id_truyen,
            truyen.tieude,
            truyen.tomtat,
            truyen.hinhanh,
            truyen.tacgia,
            admin.ten AS nguoidang,
            MAX(theloai.tentheloai) AS theloai
            FROM
            tbl_truyen truyen
            INNER JOIN
            tbl_admin admin ON truyen.id_admin = admin.id_admin
            INNER JOIN
            tbl_truyen_theloai tt ON truyen.id_truyen = tt.id_truyen
            INNER JOIN
            tbl_theloai theloai ON tt.id_theloai = theloai.id_theloai
            GROUP BY
            truyen.id_truyen
            LIMIT 8;

            ";

            $result = $mysqli->query($sql);

            ?>
            <div id="#folders" class="list">
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <div class="box">
                        <div class="thumb">
                            <a href="index.php?quanly=thongtintruyen&id_truyen=<?php echo $row['id_truyen']; ?>">
                                <img src="./admin/modules/quanlytruyen/uploads/<?php echo $row['hinhanh']; ?>" alt="Truyện <?php echo $row['tieude']; ?>" class="ithumb">
                            </a>
                        </div>
                        <div class="info-list">
                            <div class="list-name">
                                <a href="index.php?quanly=thongtintruyen&id_truyen=<?php echo $row['id_truyen']; ?>"><?php echo $row['tieude']; ?></a>
                            </div>
                            <div class="list-time">
                                Thể loại: <a href="index.php?quanly=truyen&category[]=<?php echo  $row['theloai']; ?>" class="theloai321"> <?php echo $row['theloai']; ?></a>
                            </div>
                            <div class="mota">
                                <?php echo $row['tomtat']; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    <div class="right">
        <div class="container">
            <div class="title">Đọc Nhiều Trong Tuần</div>
            <?php

            $queryDocNhieuTuan = "SELECT t.id_truyen, t.tieude, t.luotdoc, t.hinhanh, t.id_admin, a.ten,t.tacgia
            FROM tbl_truyen t
            INNER JOIN tbl_admin a ON t.id_admin = a.id_admin
            ORDER BY t.luotdoc DESC
            LIMIT 10;
            ";

            $resultDocNhieuTuan = $mysqli->query($queryDocNhieuTuan);

            if ($resultDocNhieuTuan->num_rows > 0) {

                $count = 1;
                while ($rowTruyen = $resultDocNhieuTuan->fetch_assoc()) {

                    echo '<a class="disb nav-sub menu" href="index.php?quanly=thongtintruyen&id_truyen=' . $rowTruyen['id_truyen'] . '">';
                    if ($count == 1) {
                        echo '🔥 ';
                    }
                    if ($count == 2) {
                        echo '🌟 ';
                    }
                    if ($count == 3) {
                        echo '🌷 ';
                    }
                    echo 'Top'.$count.'. <b>' . $rowTruyen['tieude'] . '</b></a>';
                    $count++;
                }
            } else {

                echo '<p>Không có dữ liệu truyện đọc nhiều tuần.</p>';
            }

            ?>
        </div>
        <div class="container">
            <div class="title">Đề Cử Tuần</div>
            <?php

            $queryDocNhieuTuan = "SELECT t.id_truyen, t.tieude, t.decu, t.hinhanh, t.id_admin, t.tacgia
            FROM tbl_truyen t
            INNER JOIN tbl_admin a ON t.id_admin = a.id_admin
            ORDER BY t.decu DESC
            LIMIT 10;
            ";

            $resultDocNhieuTuan = $mysqli->query($queryDocNhieuTuan);

            if ($resultDocNhieuTuan->num_rows > 0) {

                $count = 1;
                while ($rowTruyen = $resultDocNhieuTuan->fetch_assoc()) {

                    echo '<a class="disb nav-sub" href="index.php?quanly=thongtintruyen&id_truyen=' . $rowTruyen['id_truyen'] . '">';

                    echo "$count. ".$rowTruyen['tieude'] . '</b></a>';
                    $count++;
                }
            } else {

                echo '<p>Không có dữ liệu truyện đọc nhiều tuần.</p>';
            }

            ?>
        </div>
    </div>
</div>