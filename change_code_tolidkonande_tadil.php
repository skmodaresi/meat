<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="change_code_tolidkonande_tadil.php";
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>اصلاح کد تولید کننده</title>
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
	<tr><td colspan="4" class="title">تغییر کد</td></tr>
    <tr class="tr1"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="transfer" value="تغییر کد تعدیل"></td></tr> 
    <tr class="footer"><td colspan="4">&nbsp;</td></tr>
   </table>
   </div>
  </td>
 </tr>	
</table>
</div>';
/************اجازه براي ذخيره اطلاعات************/
//////////////////////////////////////////////////////////////////////////////////////////////
if(isset($transfer))
{
    //mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    //mysql_query('START TRANSACTION');
    //$q="SELECT * From mojody_kala LEFT JOIN tolidkonande ON mojody_kala.code_tolidkonande=tolidkonande.code_tolidkonande AND mojody_kala.code_ostan=tolidkonande.code_ostan";
    $q="SELECT * From tadil_mojody";
	//echo $q;
	$all=$db->query($q);
	while($row=$db->fetch_assoc($all))
    {
	 $name_tolid=$db->get_from_where("name_tolidkonande","tolidkonande","code_tolidkonande='".$row['code_tolidkonande']."' AND code_ostan='".$row['code_ostan']."'");
	 $q_2="SELECT code_tolidkonande From tolidkonande2 where TRIM(name_tolidkonande)='".$name_tolid."'";
	 $all_2= $db->query($q_2);
	 $row_2=$db->fetch_assoc($all_2);
	 $tolid=$row_2['code_tolidkonande'];
	 //echo $tolid.'<br/>';
	 $update_q=("UPDATE tadil_mojody SET code_tolidkonande='".$tolid."' WHERE id=".$row['id']."");
	 //echo $update_q.'<br/>'; 
	 $update_res=mysql_query($update_q); 
    }
    if($update_res)
    {
   	   //mysql_query("COMMIT");
       echo "<script>alert('changed')</script>"; 
       echo "<script>window.location='my_frame.php'</script>";
   	}
   	else  
    {
       //mysql_query('ROLLBACK');
       echo "<script>alert('error')</script>";  
    }
    //mysql_query('SET AUTOCOMMIT=1');  	  
}
////////////////////////////////////////////////////////////////////////////////////////////////
echo'
</form>
</body>
</html>';	
?>