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
<title>update_idmojody</title>
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
	<tr><td colspan="4" class="title">update_idmojody</td></tr>
    <tr class="tr1"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="update" value="اصلاح آی دی موجودی"></td></tr> 
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
    $q="SELECT * From mt_anbargardani_detail WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar  AND year=$mtActiveYear AND code_kala=78";
    
	$all = $db->query($q);
	while($row=$db->fetch_assoc($all))
    {
	   $update_q=("UPDATE mojody_kala SET id=".$row['id_mojody']." WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']."  AND year='".$row['year']."' AND code_ziranbar=".$row['code_ziranbar']."  AND code_kala=".$row['code_kala']."
		           AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']."
				   AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."'");
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