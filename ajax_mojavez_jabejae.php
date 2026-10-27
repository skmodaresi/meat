<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
/***************************ajax شروع**********************************/
/*************************************************************/
if((isset($_POST['codeOSTAN1']))AND(isset($_POST['noeMojavez'] )))//آمدن لیست انبارها با کلیک روی استان به جز خود همان انبار
{
  //آمدن لیست انبارها با کلیک روی استان به جز خود همان انبار
  if(($codeOSTAN1==$mt_gl_code_ostan)AND($noeMojavez==1)) $result7 = $db->query("SELECT code_anbar,name_anbar FROM list_sardkhane WHERE code_ostan='$codeOSTAN1' AND code_anbar!='$mt_gl_code_anbar' ORDER BY name_anbar");
  else $result7 = $db->query("SELECT code_anbar,name_anbar FROM list_sardkhane WHERE code_ostan='$codeOSTAN1' AND code_anbar!=301 ORDER BY name_anbar"); 
  while($row7=$db->fetch_assoc($result7))  
   $anbar_options .= "<option value=".$row7['code_anbar'].">".$row7['name_anbar']."</option>";
  echo $anbar_options;   
}
?>