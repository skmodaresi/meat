<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_amel_pardakht.php";
$TableName="amel_pardakht";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$radif=1;
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>چاپ عامل پرداخت پسکرایه</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<style>
       @media screen
       {
           .hideatprint
           {
           }
       }
       @media print
       {
           .hideatprint
           {
               display: none;
           }
       }
</style>
</head>';	
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" >
 <!--هدر-->
   <br/>
   <table width="99%" border="1" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr><td class="print_title_2"> سردخانه  : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
    <tr><td class="print_title_2">عامل پرداخت پسکرایه&nbsp&nbsp(صفحه : 1)
	    <span style="float:right"><a href="javascript:window.print();"><img src="images/PrinterText.png" onmouseOver="this.src=\'images/PrinterText-hover.png\'" onmouseOut="this.src=\'images/PrinterText.png\'" title="چاپ" id="IMG1" class="hideatprint"/></a></span>
		</td>
	</tr>
   </table>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->
  <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
   <tr class="print_table-title">
	  <td width="10%">رديف</td>
	  <td width="20%">کد حسابداری</td>
	  <td width="15%">کد پرسنلی</td>
	  <td width="20%">نام</td>
	  <td width="25%">نام خانوادگی</td>
	  <td width="10%">وضعیت</td>
   </tr>';
   $q1="SELECT * FROM $TableName WHERE code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' order by amel_p_accnting_code ASC";	  		  
   $allAmelP = $db->query($q1);
   $page=1;
   $line=0;
   $i=0;$cntr=0;
   $MaxLines=25;
   $cntr =mysql_num_rows($allAmelP);
   while($row1=$db->fetch_assoc($allAmelP))
   {
     $line++;
     if($i++%2) echo'<tr class="print_table-odd"/>';
     else echo '<tr class="print_table-even"/>';
     echo'
	  <td>'.$radif++.'</td>
	  <td>'.$row1['amel_p_accnting_code'].'</td>
	  <td>'.$row1['amel_p_code_personely'].'</td>
	  <td>'.$row1['amel_p_name'].'</td>
	  <td>'.$row1['amel_p_lastname'].'</td>
	  <td>'.$statusAmelArr[$row1['status_amel_p']].'</td>';	 
	echo '
	</tr>';
	if($line>=$MaxLines && $i <$cntr) 
	{
	 $line=0;
     $page++;
	 echo'
   </table>
	 <br class="pbreak">
     <br/>
	 <table width="99%" border="1" align="center">
      <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
      <tr><td class="print_title_2"> سردخانه  : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
      <tr><td class="print_title_2">عامل پرداخت پسکرایه&nbsp&nbsp(صفحه : '.$page.')
	    	</td>
	  </tr>
     </table>
	 <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	  <tr class="print_table-title">
	   <td width="10%">رديف</td>
	   <td width="20%">کد حسابداری</td>
	   <td width="15%">کد پرسنلی</td>
	   <td width="20%">نام</td>
	   <td width="25%">نام خانوادگی</td>
	   <td width="10%">وضعیت</td>
	  </tr>';
	 }
	}
   echo'
  </table>
<!--پايان مرکز صفحه -->
<!-- چاپ زیرنویس-->
<table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474"> 
 <tr class="print_footer">
  <td>&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
 </tr>	
</table>
</body>
</html>';	
?>