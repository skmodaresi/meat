<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="status_webservice.php";
$titr='فعال / غیرفعال کردن ارسال اطلاعات به وب سرویس';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
</head>';
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.sal_mabda.focus();">
<form method="POST" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr><td colspan="4" class="title">'.$titr.'</td></tr>';
    $q_active="SELECT COUNT(*) AS count_anbar_active FROM list_sardkhane WHERE activate=1 AND chkwebservice=1";
    $res_active = $db->query($q_active);
    $count_anbar_active = mysql_result($res_active, 0, 'count_anbar_active');
	//echo $count_anbar_active.'<br>';
	$q_deactive="SELECT COUNT(*) AS count_anbar_deactive FROM list_sardkhane WHERE activate=1 AND chkwebservice=0";
    $res_deactive = $db->query($q_deactive);
    $count_anbar_deactive = mysql_result($res_deactive, 0, 'count_anbar_deactive');
	//echo $count_anbar_deactive;
	IF($count_anbar_active>$count_anbar_deactive)
	 echo'<tr class="tr1" ><td height="40px">در حال حاضر ارسال به وب سرویس در بیشتر سردخانه ها فعال است</td></tr>';	
	ELSE IF($count_anbar_deactive>$count_anbar_active)
	 echo'<tr class="tr1" ><td height="40px">در حال حاضر ارسال به وب سرویس در بیشتر سردخانه ها غیرفعال است</td></tr>';	
	IF($count_anbar_deactive>$count_anbar_active)
	 echo'<tr class="tr1"><td colspan="4" height="80px"><input class="buttonme" type="submit" name="transfer_active" value="فعال کردن وب سرویس انبارها"></td></tr>';
    IF($count_anbar_active>$count_anbar_deactive)
	 echo' <tr class="tr1"><td colspan="4" height="80px"><input class="buttonme" type="submit" name="transfer_deactive" value="غیر فعال کردن وب سرویس انبارها"></td></tr>'; 
    echo'
	<tr class="footer"><td colspan="4">&nbsp;</td></tr>
   </table>
  </td>
 </tr>	
</table>
</div>';
////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($transfer_active))
{
    $update_q=("UPDATE meat.list_sardkhane SET chkwebservice=1 WHERE activate=1 AND code_anbar!=301");	
	$update_res=mysql_query($update_q);
    if(($update_res) and (mysql_affected_rows()!=0))
    { 
       echo "<script>alert('ارسال اطلاعات به وب سرویس فعال شد')</script>";
	   echo '<script>window.location=\''.$FileName.'\' </script>'; 
    }	  
}
//////////////////////////////////////////////////////////////////////////////////////////////
if(isset($transfer_deactive))
{
    $update_q=("UPDATE meat.list_sardkhane SET chkwebservice=0 WHERE activate=1 AND code_anbar!=301");	
	$update_res=mysql_query($update_q);
    if(($update_res) and (mysql_affected_rows()!=0))
    { 
       echo "<script>alert('ارسال اطلاعات به وب سرویس غیرفعال شد')</script>";
	   echo '<script>window.location=\''.$FileName.'\' </script>'; 	   
    }	  
}
echo'
</form>
</body>
</html>';	
?>