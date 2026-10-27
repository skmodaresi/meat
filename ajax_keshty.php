<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>window.location='mainpage.php';</script>";
/***************************ajax شروع**********************************/
if(isset($_POST['codeKESHTY']))//اطلاعات کالا
{
  $res0 =$db->query("SELECT name_keshty FROM keshty WHERE code_keshty='$codeKESHTY'");
  $row0=$db->fetch_assoc($res0);
  echo $row0['name_keshty'];  
}
?>