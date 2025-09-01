<?php
$config_file_exists = file_exists('../_db_config.php');
if(!$config_file_exists) {
    header("location: /install.php");
    exit();
}
$webadmin = $_COOKIE['webadmin'] ?? null;
$passadmin = defined('webadmin') ? webadmin : '127001';
if($webadmin != $passadmin) {
    include_once 'config/config.php';
    include_once 'webadmin.php';
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
<!-- Thư viện Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

<link rel="shortcut icon" type="image/png" href="../assets/image/logo.ico">

<!-- Thư viện Summernote -->


<title>Mê truyện chữ  </title>
</head>
<body>
    
    <?php include('./modules/header.php'); ?>
    <div class="main-container">

        <?php include('./modules/menu.php'); ?>
        <?php include('./modules/main.php'); ?>
    </div>
</body>
</html>
