<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
/***************************ajax شروع**********************************/
if(isset($_POST['codeOSTAN1']))//آمدن لیست انبارها با کلیک روی استان
{
  $result7 = $db->query("SELECT code_anbar,name_anbar FROM list_sardkhane WHERE code_ostan='$codeOSTAN1' ORDER BY name_anbar");
  $anbar_options="<option value=0>انتخاب کنيد</option>";
  while($row7=$db->fetch_assoc($result7))  
   $anbar_options .= "<option value=".$row7['code_anbar'].">".$row7['name_anbar']."</option>";
  echo $anbar_options;   
}
/*************************************************************/
if(isset($_POST['codeKESHTY']))//اطلاعات کشتی و شماره سفر
{
  $shomare_safar_options="<option value=0>انتخاب کنيد</option>";
  $result4 = $db->query("SELECT * FROM shomare_safar WHERE code_skk='$codeKESHTY'");
  while($row4=$db->fetch_assoc($result4))  
   $shomare_safar_options .= "<option value=".$row4['id_safar'].">".$row4['shomare_safar']."</option>";
  echo $shomare_safar_options;   
}
?>