<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
/***************************ajax شروع**********************************/
//چک کردن کدبسته بندی کالا و نوع بسته بندی انتخاب شده
if((isset($_POST['codekalaForValidate']))and(isset($_POST['bastebandyForValidate'])))
{
 if(empty($_POST['codekalaForValidate']))  echo'<img border="0" src="images/pen.png" onmouseOver="this.src=\'images/pen_hover.png\'" onmouseOut="this.src=\'images/pen.png\'"  title="کد کالا را وارد نمایید" style="cursor:pointer"/>';
 else
 { 
  $q=("SELECT code_bastebandy FROM kala WHERE code_kala='$codekalaForValidate'");
  $res=mysql_query($q);
  $row=mysql_fetch_assoc($res);
  if($row['code_bastebandy']!=$bastebandyForValidate)
   echo'<img border="0" src="images/dont1.png" onmouseOver="this.src=\'images/dont1_hover.png\'" onmouseOut="this.src=\'images/dont1.png\'"   title="بسته بندی این کالا با نوع بسته بندی انتخاب شده مغایرت دارد ! امکان اتنخاب این کالا وجود ندارد" style="cursor:pointer"/>';
 }
}
/*************************************************************/ 
?>