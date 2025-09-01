<div class="container-fluid">
    <div class="row">
        <!-- Menu -->


        <!-- Nội dung chính -->
            <?php
            include('./admin/config/config.php');

           if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

                if(isset($_GET['quanly'])){
                    $tam = $_GET['quanly'];
                 }else{
                    $tam = '';
                 }
         
           
                 

                if($tam=='thongtintruyen'){
                    include('./pages/thongtintruyen.php');

                }elseif($tam=='doc'){
                    include('./pages/chuong.php');

                }elseif($tam=='truyen'){
                    include('./pages/truyen.php');

                }elseif($tam=='danhgia'){
                    include('./pages/xuly_danhgia.php');
                }elseif($tam=='decu'){
                    include('./pages/decu.php');
                }elseif($tam=='yeuthich'){
                    include('./pages/yeuthich.php');
 
                }elseif($tam=='comment'){
                    include('./pages/comment.php');
 
                }elseif($tam=='thongtintaikhoan'){
                    include('./pages/thongtintaikhoan.php');
                }elseif($tam=='xuly'){
                    include('./pages/xuly.php');

                }elseif($tam=='dangnhap'){
                    include('./pages/dangnhap.php');
                }elseif($tam=='dangki'){
                     include('./pages/dangky.php');
                }elseif($tam=='dangxuat'){
                    include('./pages/logout.php');

                    
                } else {
                    // Nội dung mặc định khi không có trang cụ thể được yêu cầu
                    include('index.php' );
                }
            ?>

    </div>
</div>
