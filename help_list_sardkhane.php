<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_list_sardkhane.php";
$TableName="list_sardkhane";
$radif=1;
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>جدول کد سردخانه</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>';
echo"
<script type='text/javascript'>
function substitute(code_val)
{
 window.opener.document.myform.code_anbar.value=code_val;
 window.opener.document.myform.code_anbar.focus();
 window.close();
}
</script>
</head>";
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="post" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">جدول کد سردخانه</td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->	
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden; ">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
   	<tr class="table-title">
	 <td width="10%">رديف</td>
	 <td width="25%">کداستان</td>
	 <td width="25%">کد سردخانه</td>
	 <td width="40%">نام انبار</td>
	</tr>';
   $Cntr=0;
   $q1="SELECT * From $TableName WHERE code_ostan='$mt_gl_code_ostan' order by id asc";
   $allAnbar = $db->query($q1);
   while($row1=$db->fetch_assoc($allAnbar))
   {
    $editclick="onclick='substitute(\"".$row1['code_anbar']."\")'";   
     if($Cntr++%2) echo'<tr class="table-odd"/>';
     else echo '<tr class="table-even"/>';
     echo'
	  <td '.$editclick.'>'.$radif++.'</td>
	  <td '.$editclick.'>'.$row1['code_ostan'].'</td>
	  <td '.$editclick.'>'.$row1['code_anbar'].'</td>
	  <td '.$editclick.'>'.$row1['name_anbar'].'</td>';
	echo '
	</tr>';
	}
	echo'
   </table>
   </div>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->	
</table>
</div>
</form>
</body>
</html>';	
?>