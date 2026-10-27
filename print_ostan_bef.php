<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>window.location='mainpage.php';</script>";
$FileName="print_ostan.php";
$TableName="ostan";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$count=1;
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>چاپ استان ها</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>';
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="post" name="myform">
<div align="center">
<table width="700px" height="90%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td>
   <table width="100%" border="1" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr><td class="print_title_2"> انبار : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
    <tr><td class="print_title_2">جدول کد استان ها</td></tr>
   </table>
  </td>
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->	
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden; ">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">';
   $RowPerPage=25;
   $Page=0;
   $Line=100;
   $Cntr=0;
   $q1="SELECT *,(SELECT count(*) FROM shahrestan as sh WHERE sh.code_ostan=T.code_ostan) shahrCount From $TableName T order by name_ostan ASC";
   $allOstan = $db->query($q1);
   while($row1=$db->fetch_assoc($allOstan))
   {if ($Line>=$RowPerPage)
    {if ($Page) echo "<br>";
     $Line=0; 
	 echo'
	 <tr class="print_table-title">
	  <td width="25%">رديف</td>
	  <td width="25%">کد استان</td>
	  <td width="25%">نام استان</td>
	  <td width="25%">تعداد شهرستان ها</td>
	 </tr>';
	}
     $Line++;
     if($Cntr++%2) echo'<tr class="print_table-odd"/>';
     else echo '<tr class="print_table-even"/>';
	  echo'
	  <td>'.$count++.'</td>
	  <td>'.$row1['code_ostan'].'</td>
	  <td>'.$row1["name_ostan"].'</td>
	  <td>'.$row1['shahrCount'].'</td>';
	echo '
	</tr>';
   }
   echo'
   </table>
   </div>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->
 <!-- چاپ زیرنویس-->
 <tr class="print_footer">
  <td colspan="3">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
 </tr>	 
</table>
</div>
</form>
</body>
</html>';	
?>