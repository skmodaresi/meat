<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_moshtary.php";
//if($_SESSION['mt_systemforush']==0){$TableName="moshtary";}//اطلاعات مشتری از سیستم انبار
//if($_SESSION['mt_systemforush']==1)//اطلاعات مشتری از سیستم فروش
//{
 mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());
 $TableName="dm_customer_asli";
//}
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$radif=1;
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>چاپ مشتريان</title>
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
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
 <!--هدر-->
 <br/>
 <table width="99%" border="1" align="center">
  <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
  <tr><td class="print_title_2"> سردخانه  : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
  <tr><td class="print_title_2">جدول مشتریان&nbsp&nbsp(صفحه : 1)
    <span style="float:right"><a href="javascript:window.print();"><img src="images/PrinterText.png" onmouseOver="this.src=\'images/PrinterText-hover.png\'" onmouseOut="this.src=\'images/PrinterText.png\'" title="چاپ" id="IMG1" class="hideatprint"/></a></span>
	</td>
  </tr>
 </table>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->	
 <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
   <tr class="print_table-title">
    <td width="5%">رديف</td>
    <td width="10%">کد مشتری</td>
    <td width="30%">نام مشتری</td>
    <td width="10%">شناسه ملی</td> 
	<td width="10%">کد / شماره ملی</td> 
    <td width="35%">آدرس مشتری</td>
   </tr>'; 
   // if($_SESSION['mt_systemforush']==0){
    // // $q1="SELECT $TableName.*,ostan.name_ostan,shahrestan.city_name FROM $TableName
	     // // LEFT OUTER JOIN ostan ON ostan.code_ostan=$TableName.code_ostan 
	     // // LEFT OUTER JOIN shahrestan ON shahrestan.code_ostan=ostan.code_ostan AND $TableName.city_code=shahrestan.city_code
	     // // WHERE $TableName.code_ostan='$mt_gl_code_ostan' AND LENGTH(trim(code_economic_customer))>=10 order by code_customer ASC";
      // $q1="SELECT * FROM $TableName order by code_customer ASC"; 
	// }
	// //سیستم فروش
	// else{
	 // // $q1="SELECT $TableName.*,dm_province.province_name,dm_city.city_name FROM $TableName
	      // // LEFT OUTER JOIN dm_province ON dm_province.province_id=$TableName.customer_province_id 
	      // // LEFT OUTER JOIN dm_city ON $TableName.customer_city_id=dm_city.city_id AND dm_city.city_province=dm_province.province_id 
	      // // WHERE customer_code_org='$mt_gl_code_ostan' AND LENGTH(trim(code_economic_customer))>=10 order by code_customer ASC";	
	  // $q1="SELECT * FROM $TableName WHERE  LENGTH(trim(code_economic_customer))>=10 order by code_customer ASC";	
	// }
    $q1="SELECT $TableName.code_customer,$TableName.name_customer,$TableName.customer_national_tax,$TableName.customer_gl_code,dm_customer_det.customer_address_office FROM $TableName LEFT OUTER JOIN dm_customer_det ON $TableName.code_customer=dm_customer_det.code_customer  WHERE 1=1 ".$_SESSION['mt_search_moshtary']." AND dm_customer_det.customer_code_org='$mt_gl_code_ostan' AND (LENGTH(trim(customer_national_tax))>=10 OR LENGTH(trim(customer_gl_code))>=10) order by code_customer ASC";	
    $allMoshtary = $db->query($q1);
    $page=1;
    $line=0;
    $i=0;$cntr=0;
    $MaxLines=20;
    $cntr =mysql_num_rows($allMoshtary);
   while($row1=$db->fetch_assoc($allMoshtary))
   {
	 $line++;
	 if($i++%2) echo'<tr class="print_table-odd"/>';
     else echo '<tr class="print_table-even"/>';
     echo'
	  <td>'.$radif++.'</td>
	  <td>'.$row1['code_customer'].'</td>
	  <td>'.$row1['name_customer'].'</td>';
	  // if($_SESSION['mt_systemforush']==0) echo'<td>'.$row1['name_ostan'].'</td>';
	  // else echo'<td>'.$row1['province_name'].'</td>';
      // echo'<td>'.$row1['city_name'].'</td>';
	  echo'
	  <td>'.$row1['customer_national_tax'].'</td>
	  <td>'.$row1['customer_gl_code'].'</td>
	  <td>'.$row1['customer_address_office'].'</td>';
	echo '
	</tr>';
	if ($line>=$MaxLines && $i <$cntr) 
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
            <tr><td class="print_title_2">جدول مشتریان&nbsp&nbsp(صفحه : '.$page.')
	        	</td>
	        </tr>
           </table>
		   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
		    <tr class="print_table-title">
             <td width="5%">رديف</td>
             <td width="10%">کد مشتری</td>
             <td width="30%">نام مشتری</td>
             <td width="10%">شناسه ملی</td> 
	         <td width="10%">کد / شماره ملی</td> 
             <td width="35%">آدرس مشتری</td>
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