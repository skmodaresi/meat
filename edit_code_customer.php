<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="edit_code_customer.php";
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>اصلاح کدمشتری در حواله</title>
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
	<tr><td colspan="4" class="title">اصلاح کدمشتری در حواله های استان '.$mt_gl_name_ostan.' در تمام سال ها</td></tr>
    <tr class="tr1"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="transfer" value="اصلاح کد"></td></tr> 
    <tr class="footer"><td colspan="4">&nbsp;</td></tr>
   </table>
   </div>
  </td>
 </tr>	
</table>
</div>';
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($gl_c_o)
{
 $flag=false;
 if(!($gl_c_o) or $gl_c_o==-1)//اگر سشن استان خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true;
return $flag;
}
//////////////////////////////////////////////////////////////////////////////////////////////
if(isset($transfer))
{
  if(isPermitSave($mt_gl_code_ostan))				  
  {
    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');
    //$q="SELECT * From meat.havale WHERE code_ostan='$mt_gl_code_ostan' AND year=$mtActiveYear AND h_code!=0 AND deleted=0";
    $q="SELECT * From meat.havale WHERE code_ostan='$mt_gl_code_ostan' AND h_code!=0 AND deleted=0";
	$all = $db->query($q);
    while($row=$db->fetch_assoc($all))
    {
         $db->selectDb('sell');
		 //پیدا کردن آی دی کد استان مربوط به سیتم فروش
          $res_ostan=mysql_query("SELECT province_id FROM sell.dm_province WHERE province_code='$mt_gl_code_ostan'");
          $sell_id_ostan=mysql_result($res_ostan, 0, 'province_id');
         //پیدا کردن آی دی کد انبار مربوط به سیستم فروش
          $res_anbar=mysql_query("SELECT l_id FROM sell.dm_location_goods WHERE l_id_province='$sell_id_ostan' AND l_code=".$row['code_anbar']."");
          $sell_id_anbar=mysql_result($res_anbar, 0, 'l_id');
         //پیدا کردن آی دی سال مربوط به سیستم فروش
          //$sellYearCode=substr($mtActiveYear,2);
		  $sellYearCode=substr($row['year'],2);
          $res_sal=mysql_query("SELECT year_id FROM sell.dm_year WHERE year_code='$sellYearCode'");
          $sellYearId=mysql_result($res_sal, 0, 'year_id');
          //بدست آوردن تاریخ ومقدار حواله فروش و مانده از فروش
  	     $q_havale_forush="SELECT h_customer_code FROM sell.dm_havale WHERE h_code='".$row['h_code']."' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId'";
		 $res_havale_forush=mysql_query($q_havale_forush);
         $row_havale_forush=mysql_fetch_array($res_havale_forush);
	     $update_customer=("UPDATE meat.havale SET code_customer=".$row_havale_forush['h_customer_code']." WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND shomare_havale_anbar='".$row['shomare_havale_anbar']."' AND year=".$row['year']."");
	     $update_res=mysql_query($update_customer);
    }
    if($update_res)
    {
   	   mysql_query("COMMIT");
       echo "<script>alert('ok')</script>"; 
       echo "<script>window.location='my_frame.php'</script>";
   	}
   	else  
    {
       mysql_query('ROLLBACK');
       echo "<script>alert('with problem')</script>";  
    }
    mysql_query('SET AUTOCOMMIT=1');
   }	  
}
////////////////////////////////////////////////////////////////////////////////////////////////
echo'
</form>
</body>
</html>';	
?>