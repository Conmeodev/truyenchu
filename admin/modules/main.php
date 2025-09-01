<!-- modules/main.php -->
<div class="container-fluid">
    <div class="row">
        <!-- Menu -->

        <!-- Nội dung chính -->
        <?php
        include('config/config.php');

        if(isset($_GET['action']) && $_GET['query']){
            $tam = $_GET['action'];
            $query = $_GET['query'];
        } else {
            $tam = '';
            $query = '';
        }

        if($tam=='quanlytruyen' && $query=='them'){
            include('./modules/quanlytruyen/them.php' );
        } elseif($tam=='quanlytruyen' && $query=='lietke'){
            include('./modules/quanlytruyen/lietke.php' );
        } elseif($tam=='quanlytruyen' && $query=='themchuong'){
            include('./modules/quanlytruyen/themchuong.php' );
        } elseif($tam=='quanlytruyen' && $query=='sua'){
            include('./modules/quanlytruyen/sua.php' );
        } elseif($tam=='quanlytruyen' && $query=='xuly'){
            include('./modules/quanlytruyen/xuly.php' );

        } elseif($tam=='quanlychuong' && $query=='lietke'){
            include('./modules/quanlychuong/lietke.php' );
        } elseif($tam=='quanlychuong' && $query=='them'){
            include('./modules/quanlychuong/them.php' );
        } elseif($tam=='quanlychuong' && $query=='themchuong'){
            include('./modules/quanlychuong/themchuong.php' );
        } elseif($tam=='quanlychuong' && $query=='sua'){
            include('./modules/quanlychuong/sua.php' ); 
        } elseif($tam=='quanlychuong' && $query=='xuly'){
            include('./modules/quanlychuong/xuly.php' ); 

        } elseif($tam=='quanlytheloai' && $query=='lietke'){
            include('./modules/quanlytheloai/lietke.php' ); 
        } elseif($tam=='quanlytheloai' && $query=='xuly'){
            include('./modules/quanlytheloai/xuly.php' ); 
        } elseif($tam=='quanlytheloai' && $query=='sua'){
            include('./modules/quanlytheloai/sua.php' );

        } elseif($tam=='quanlyslide' && $query=='lietke'){
            include('./modules/quanlyslide/lietke.php' ); 
        } elseif($tam=='quanlyslide' && $query=='xuly'){
            include('./modules/quanlyslide/xuly.php' ); 
        } elseif($tam=='quanlyslide' && $query=='sua'){
            include('./modules/quanlyslide/sua.php' );

        } elseif($tam=='quanlytaikhoan' && $query=='lietke'){
            include('./modules/quanlytaikhoan/lietke.php' );
        } elseif($tam=='quanlytaikhoan' && $query=='sua'){
            include('./modules/quanlytaikhoan/sua.php' );
        } elseif($tam=='quanlytaikhoan' && $query=='xuly'){
            include('./modules/quanlytaikhoan/xuly.php' );

        } elseif($tam=='trangchu' && $query=='home'){
            if (!isset($_SESSION['id_admin'])) {
                echo '<div style="display: flex ; width: 100vw; height: 100vh; justify-content: center; align-items: center;"><a class="btn btn-primary" href="index.php?action=dangnhap&query=dangnhap">Đăng nhập admin</a></div>';
                exit();
            } else {
                include('./modules/quanlytruyen/lietke.php' );
            }

        } elseif($tam=='dangnhap' && $query=='dangnhap'){
            include('./modules/dangnhap.php' ); 
        } elseif($tam=='dangky' && $query=='dangky'){
            include('./modules/dangky.php' ); 
        } else {
            if (!isset($_SESSION['id_admin'])) {
                echo '<div style="display: flex ; width: 100vw; height: 100vh; justify-content: center; align-items: center;"><a class="btn btn-primary" href="index.php?action=dangnhap&query=dangnhap">Đăng nhập admin</a></div>';
                exit();
            } else {
                include('./modules/quanlytruyen/lietke.php' );
            }
        }
        ?>

    </div>
</div>
