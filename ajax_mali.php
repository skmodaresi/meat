<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
/***************************ajax شروع**********************************/
/*************************************************************/
if(isset($_POST['codeSKK']))//اطلاعات کشتی و شماره سفر
{
  $name_skk=$db->get_from_where("name_skk","meat.mt_skk","code_skk='$codeSKK'");
  $code_mali=$db->get_from_where("code","mali.acc_mofaser_detail","mk=16 AND year=95 AND name='$name_skk'");
  echo $name_skk.'^'.$code_mali;   
  //echo $q2;   
}
?>