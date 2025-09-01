<?php
$config_file_exists = file_exists('_db_config.php');
if(!$config_file_exists) {
    header("location: /install.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="index, follow" name="robots"/>
    <meta name="theme-color" content="#ffffff" id="theme-color-meta" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">

    <title>Đọc truyện online, đọc truyện chữ, truyện full, truyện hay. Tổng hợp đầy đủ và cập nhật liên tục.</title>
    
    <meta name="description" content="Đọc truyện online, đọc truyện chữ, truyện full, truyện hay. Tổng hợp đầy đủ và cập nhật liên tục.">
    <meta name="keywords" content="Đọc truyện online, đọc truyện chữ, truyện full, truyện hay. Tổng hợp đầy đủ và cập nhật liên tục.">
    <meta name="author" content="CONMEODEV">
    <link rel="canonical" href="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">

    <!-- Open Graph -->
    <meta property="og:title" content="Đọc truyện online, đọc truyện chữ, truyện full, truyện hay. Tổng hợp đầy đủ và cập nhật liên tục.">
    <meta property="og:description" content="Đọc truyện online, đọc truyện chữ, truyện full, truyện hay. Tổng hợp đầy đủ và cập nhật liên tục.">
    <meta property="og:image:width" content="250" />
    <meta property="og:image:height" content="250" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:alt" content="Đọc truyện online, đọc truyện chữ, truyện full, truyện hay. Tổng hợp đầy đủ và cập nhật liên tục.">
    <meta property="og:site_name" content="Đọc truyện online, đọc truyện chữ, truyện full, truyện hay. Tổng hợp đầy đủ và cập nhật liên tục.">
    <meta property="og:url" content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $title; ?>">
    <meta name="twitter:description" content="<?php echo $meta_description.' - '.$domain; ?>">
    <meta name="twitter:image" content="<?php echo $meta_thumb; ?>">

    <!-- DMCA & Other -->
    <meta name="dmca-site-verification" content="dDVBN2oxcUtlcWRZWVNzSDA5MWJLR3VOZU5NTldtbTl1NzBxelZrZ2VGMD01" />
    <meta name="clckd" content="540f7543675fb09f48c3e35050fdadf2" />

    <!-- Stylesheet -->
    <link rel="stylesheet" href="./assets/css/styles.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" type="image/png" href="assets/image/logo.ico">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spark-md5/3.0.2/spark-md5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" ></script>
</head>

<body>
<?php 
include("pages/header.php");
include("pages/main.php");
include("pages/footer.php");


?>





</body>
</html>
