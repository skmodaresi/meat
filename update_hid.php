<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="update_hid.php";
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>update_hid</title>
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
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr><td colspan="4" class="title">update_hid</td></tr>
    <tr class="tr1"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="update" value="انتقال"></td></tr> 
    <tr class="footer"><td colspan="4">&nbsp;</td></tr>
   </table>
   </div>
  </td>
 </tr>	
</table>
</div>';

//////////////////////////////////////////////////////////////////////////////////////////////
if(isset($update))
{
    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');
    //$q="SELECT * From havale WHERE year=$mtActiveYear AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND h_code!=0";
    $q="SELECT * From havale WHERE code_ostan=$mt_gl_code_ostan AND h_code!=0 AND year<1395";
    
	$all = $db->query($q);
	while($row=$db->fetch_assoc($all))
    {
       //پیدا کردن آی دی کد استان مربوط به سیتم فروش
       $res_ostan=mysql_query("SELECT province_id FROM sell.dm_province WHERE province_code=".$row['code_ostan']."");
       $_SESSION['sell_id_ostan']=mysql_result($res_ostan, 0, 'province_id');
       $sell_id_ostan=$_SESSION['sell_id_ostan'];
       //پیدا کردن آی دی کد انبار مربوط به سیستم فروش
       $res_anbar=mysql_query("SELECT l_id FROM sell.dm_location_goods WHERE l_id_province='$sell_id_ostan' AND l_code=".$row['code_anbar']."");
       $_SESSION['sell_id_anbar']=mysql_result($res_anbar, 0, 'l_id');
       $sell_id_anbar=$_SESSION['sell_id_anbar'];
       //پیدا کردن آی دی سال مربوط به سیستم فروش
       $year_me=$row['year'];
	   $sellYearCode=substr($year_me,2);
       $res_sal=mysql_query("SELECT year_id FROM sell.dm_year WHERE year_code='$sellYearCode'");
       $_SESSION['sellYearId']=mysql_result($res_sal, 0, 'year_id');
       $sellYearId=$_SESSION['sellYearId'];
	   $q2="SELECT h_id From sell.dm_havale WHERE dm_havale.h_code=".$row['h_code']." AND dm_havale.h_id_province='$sell_id_ostan' AND dm_havale.h_l_code='$sell_id_anbar' AND dm_havale.h_id_year='$sellYearId'";
	   
	   //$q2="SELECT id From havale_forush WHERE h_code=".$row['h_code']." AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']."  AND year='".$row['year']."'";
	   $result2= mysql_query($q2);
	   $row2=mysql_fetch_assoc($result2);
	   //$h_id=$row2['id'];
	   $h_id=$row2['h_id'];
	   $update_q=("UPDATE havale SET h_id=$h_id WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']."  AND year='".$row['year']."' AND id=".$row['id']."");
	   $update_res=mysql_query($update_q);
    }
    if($update_res)
    {
   	 mysql_query("COMMIT");
       echo "<script>alert('success')</script>"; 
   	}
   	else  
    {
       mysql_query('ROLLBACK');
       echo "<script>alert('error!')</script>";  
    }
    mysql_query('SET AUTOCOMMIT=1');
   	  
}
////////////////////////////////////////////////////////////////////////////////////////////////
echo'
</form>
</body>
</html>';	
?>