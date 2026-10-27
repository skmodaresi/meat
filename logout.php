<?php
session_start();
require_once "config.php";
error_reporting(0);
/*کوئري لاگ*/
$log_i=$db->query("INSERT INTO log (user_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','خروج با کليک روي خروج',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");   
session_destroy();
session_unset();
echo "<script>window.location='mainpage.php';</script>";
// header('location: index.php');
?>