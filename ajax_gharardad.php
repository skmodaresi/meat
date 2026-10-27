<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
/***************************ajax شروع**********************************/
// if(isset($_POST['idFORUSHANDE']))//اطلاعات فروشنده
// {
  // $result_1 =$db->query("SELECT * FROM forushande WHERE id_forushande='$idFORUSHANDE'"); 
  // $row_1=$db->fetch_assoc($result_1);
  // echo $row_1['code_forushande'].'^'.$row_1['name_forushande'];   
// }

if(isset($_POST['codeFORUSHANDE']))//اطلاعات فروشنده
{
  $result_1 =$db->query("SELECT * FROM mt_skk WHERE code_skk='$codeFORUSHANDE'"); 
  echo "SELECT * FROM mt_skk WHERE code_skk='$codeFORUSHANDE'";
  $row_1=$db->fetch_assoc($result_1);
  echo $row_1['code_skk'].'^'.$row_1['name_skk'];   
}
/*************************************************************/
if(isset($_POST['idSAHMIE']))//اطلاعات سهمیه بندی
{
  $result_2=$db->query("SELECT * FROM sahmiebandy_kharid WHERE id_sahmiebandy='$idSAHMIE'"); 
  $row_2=$db->fetch_assoc($result_2);
  echo $row_2['shomare_dastorolamal'];   
}
?>