<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_shahrestan.php";
$TableName="shahrestan";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$count=1;
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>چاپ شهرستان ها</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
</head>';
//$pageMaster = $_GET['pageMaster'];
// خواندن اطلاعات جدول استان ها
$c=$db->query("SELECT * FROM ostan WHERE code_ostan='$codeOstan_'");
$r=$db->fetch_array($c);
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="post" name="myform">
<div align="center">
<table width="700px" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td>
   <table width="100%" border="1" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr><td class="print_title_2"> انبار : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
    <tr><td class="print_title_2">شهرستانهای استان &nbsp;'.$r['name_ostan'].'</td></tr>
   </table>
  </td>
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">';
   $RowPerPage=25;
   $Page=0;
   $Line=100;
   $Cntr=0;
   //$q1="SELECT * From $TableName WHERE code_ostan='$codeOstan_' order by city_code ASC";
   $q1="SELECT * From $TableName WHERE code_ostan='$codeOstan_' order by city_name ASC";
   $allShahr=$db->query($q1);
   while($row1=$db->fetch_assoc($allShahr))
   {if ($Line>=$RowPerPage)
    {if ($Page) echo "<br>";
     $Line=0; 
     echo'
	 <tr class="print_table-title">
	  <td width="%">رديف</td>
	  <td width="">کد شهرستان</td>
	  <td width="">نام شهرستان</td>
	 </tr>';
	}
     $Line++;
     if($Cntr++%2) echo'<tr class="print_table-odd"/>';
     else echo '<tr class="print_table-even"/>';
     echo'
	  <td>'.$count++.'</td>
	  <td>'.$row1['city_code'].'</td>
	  <td>'.$row1['city_name'].'</td>';	 
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