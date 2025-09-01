<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/_db_config.php';
$mysqli = new mysqli(db_host,db_user,db_pass,db_name);
$mysqli->set_charset("utf8");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Kết nối MYSQLi lỗi: " . $mysqli -> connect_error;
  exit();
}

?>