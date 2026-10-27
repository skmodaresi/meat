<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="update_idhavale.php";
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>update_idhavale</title>
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
	<tr><td colspan="4" class="title">update_idhavale</td></tr>
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
    $q="SELECT * From resid WHERE year=$mtActiveYear and (noe_tahvil_bar=4 or noe_tahvil_bar=5) and id_havale is null";
	$all = $db->query($q);
	while($row=$db->fetch_assoc($all))
    {  
	   $q2="SELECT id From havale WHERE code_ostan=".$row['code_ostan_mabda']." AND code_anbar=".$row['code_anbar_mabda']." AND shomare_havale_anbar='".$row['shomare_havale_anbar']."' AND year=".$row['year']."";
	   $result2= mysql_query($q2);
	   $row2=mysql_fetch_assoc($result2);
	   $id_havale=$row2['id'];
	   $update_q=("UPDATE resid SET id_havale=$id_havale WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']."  AND year='".$row['year']."' AND id=".$row['id']."");
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