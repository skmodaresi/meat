<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_mojody.php";
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>انتقال موجودی به سال بعد</title>
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
	<tr><td colspan="4" class="title">اصلاح کد</td></tr>
    <tr class="tr1"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="transfer" value="اصلاح"></td></tr> 
    <tr class="footer"><td colspan="4">&nbsp;</td></tr>
   </table>
   </div>
  </td>
 </tr>	
</table>
</div>';
//////////////////////////////////////////////////////////////////////////////////////////////
if(isset($transfer))
{

    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');
    $q_mojody="SELECT * From mojody_kala WHERE year='1395'";
	$allMojody = $db->query($q_mojody);
    $sum_karton_this_new=0;
	while($row=$db->fetch_assoc($allMojody))
    {
	   $codeBastebandy=$db->get_from_where("code_bastebandy","kala","code_kala=".$row['code_kala']."");     
	   $update_q=("UPDATE mojody_kala SET code_bastebandy=$codeBastebandy WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND year=".$row['year']." AND id=".$row['id']."");
	   $update_res=mysql_query($update_q);

    }
    if($update_res)
    {
   	 mysql_query("COMMIT");
       echo "<script>alert('انجام شد')</script>"; 
       echo "<script>window.location='my_frame.php'</script>";
   	}
   	else  
    {
       mysql_query('ROLLBACK');
       echo "<script>alert('مشکلی در اصلاح به وجود امده است!')</script>";  
    }
    mysql_query('SET AUTOCOMMIT=1');	  
}
////////////////////////////////////////////////////////////////////////////////////////////////
echo'
</form>
</body>
</html>';	
?>