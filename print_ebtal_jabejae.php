<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_ebtal_jabejae.php";
$TableName="ebtal_jabejae";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$count=1;
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>چاپ ابطال مقادیر مجوز جابه جایی</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
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
   <table width="99%" border="1" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr><td class="print_title_2"> سردخانه : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
    <tr><td class="print_title_2">جدول ابطال مقادیر مجوز جابه جایی&nbsp&nbsp(صفحه : 1)
	    <span style="float:right"><a href="javascript:window.print();"><img src="images/PrinterText.png" onmouseOver="this.src=\'images/PrinterText-hover.png\'" onmouseOut="this.src=\'images/PrinterText.png\'" title="چاپ" id="IMG1" class="hideatprint"/></a></span>
		</td>
	</tr>
   </table>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
  <tr class="print_table-title2">
	  <td width="5%">رديف</td>
	  <td width="10%">شماره برگه ابطال جابه جایی</td> 
	  <td width="10%">تاریخ برگه ابطال</td>	  
	  <td width="10%">شماره مجوز جابه جایی</td> 
	  <td width="10%">نام کالا</td>
	  <td width="10%">استان مقصد</td> 
	  <td width="10%">انبار مقصد</td>
	  <td width="10%">نام مشتری</td>
	  <td width="7%">مقدار باطله</td> 	  
	  <td width="10%">مقدار اولیه مجوز</td>
	  <td width="8%">مقدار تحویلی از مجوز</td>	  
	        <!--<td width="%">مقدار مانده از حواله </td>--> 	 
   </tr>';
   $page=1;
   $line=0;
   $i=0;$cntr=0;
   $MaxLines=20;
   if($_SESSION['mt_systemforush']==0)//سردخانه
   {
    $q1="SELECT $TableName.*,m_j.shomare_jabejae,m_j.tarikh_jabejae,m_j.meghdar_jabejae,m_j.code_kala,k.name_kala,o.name_ostan AS ostan_maghsad,l_a.name_anbar AS anbar_maghsad,moshtary.name_customer FROM $TableName
         INNER JOIN mojavez_jabejae m_j ON $TableName.shomare_jabejae=m_j.shomare_jabejae AND $TableName.code_ostan=m_j.code_ostan AND $TableName.code_anbar=m_j.code_anbar AND $TableName.year=m_j.year
         INNER JOIN kala k ON k.code_kala=m_j.code_kala
         LEFT JOIN moshtary ON m_j.code_customer=moshtary.code_customer
		 LEFT JOIN ostan o ON o.code_ostan=m_j.code_ostan_maghsad_j
         LEFT JOIN list_sardkhane l_a ON l_a.code_ostan=m_j.code_ostan_maghsad_j AND l_a.code_anbar=m_j.code_anbar_maghsad_j 
	     WHERE $TableName.code_ostan='$mt_gl_code_ostan' and $TableName.code_anbar='$mt_gl_code_anbar' AND $TableName.year='$mtActiveYear' AND $TableName.deleted=0 order by $TableName.id asc";
   }
   if($_SESSION['mt_systemforush']==1)//فروش
   {
    $q1="SELECT $TableName.*,m_j.shomare_jabejae,m_j.tarikh_jabejae,m_j.meghdar_jabejae,m_j.code_kala,k.name_kala,o.name_ostan AS ostan_maghsad,l_a.name_anbar AS anbar_maghsad,dm_customer_asli.name_customer FROM $TableName
         INNER JOIN mojavez_jabejae m_j ON $TableName.shomare_jabejae=m_j.shomare_jabejae AND $TableName.code_ostan=m_j.code_ostan AND $TableName.code_anbar=m_j.code_anbar AND $TableName.year=m_j.year
         INNER JOIN kala k ON k.code_kala=m_j.code_kala
         LEFT JOIN sell.dm_customer_asli ON m_j.code_customer=sell.dm_customer_asli.code_customer
		 LEFT JOIN ostan o ON o.code_ostan=m_j.code_ostan_maghsad_j
         LEFT JOIN list_sardkhane l_a ON l_a.code_ostan=m_j.code_ostan_maghsad_j AND l_a.code_anbar=m_j.code_anbar_maghsad_j 
	     WHERE $TableName.code_ostan='$mt_gl_code_ostan' and $TableName.code_anbar='$mt_gl_code_anbar' AND $TableName.year='$mtActiveYear' AND $TableName.deleted=0 order by $TableName.id asc";
   }
   $allEbtal = $db->query($q1);
   $cntr =mysql_num_rows($allEbtal);
   while($row1=$db->fetch_assoc($allEbtal))
   { 
    //محاسبه مقدار تحویلی از مجوز جابه جایی با استفاده از تابع
	$meghdar_tahvily_j=tahvily_az_jabejae($row1['shomare_jabejae'],$row1['code_ostan'],$row1['code_anbar'],$row1['year']);
    // $q21="SELECT SUM(meghdar_batele) FROM ebtal WHERE shomare_jabejae='".$row1['shomare_jabejae']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0";//محاسبه مقدار باطله
    // $res21=mysql_query($q21);
    // $meghdar_batele_ghabl=mysql_fetch_array($res21);
    //$mande_az_forush=$row1['meghdar_havale_forush']-$meghdar_tahvily[0]-$meghdar_batele_ghabl[0];//محاسبه مقدار مانده از حواله فروش 

     $line++;
     if($i++%2) echo'<tr class="print_table-odd"/>';
     else echo '<tr class="print_table-even"/>';
	 if(strlen($row1['code_ostan'])==1) $code_a=make_pattern($row1['code_ostan'],2);
     else $code_a=$row1['code_ostan'];
     echo'
	  <td>'.$count++.'</td>
	  <td>'.$row1['shomare_barge_ebtal_j'].'</td>
	  <td>'.$row1['tarikh_barge_ebtal_j'].'</td> 
	  <td>'.$row1['shomare_jabejae'].'</td>
	  <td>'.$row1['name_kala'].'</td>
	  <td>'.$row1['ostan_maghsad'].'</td>
	  <td>'.$row1['anbar_maghsad'].'</td>
	  <td>'.$row1['name_customer'].'</td>
	  <td>'.($row1['meghdar_batele_j']).'</td>
	  <td>'.($row1['meghdar_jabejae']).'</td>
	  <td>'.($meghdar_tahvily_j).'</td>	  	  
	  <!--<td>'.($mande_az_forush).'</td>-->
	  ';
	 echo '
	 </tr>';
	 if ($line>=$MaxLines && $i <$cntr) 
	  {
	     $line=0;
         $page++;
	     echo'
		   </table>
		   <br class="pbreak">
           <table width="99%" border="1" align="center">
            <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
            <tr><td class="print_title_2"> سردخانه : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
            <tr><td class="print_title_2">جدول ابطال مقادیر مجوز جابه جایی&nbsp&nbsp(صفحه : '.$page.')
	        	</td>
	        </tr>
           </table>
		   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
		    <tr class="print_table-title2">
	          <td width="5%">رديف</td>
	          <td width="10%">شماره برگه ابطال جابه جایی</td> 
	          <td width="10%">تاریخ برگه ابطال</td>	  
	          <td width="10%">شماره مجوز جابه جایی</td> 
	          <td width="10%">نام کالا</td>
	          <td width="10%">استان مقصد</td> 
	          <td width="10%">انبار مقصد</td>
	          <td width="10%">نام مشتری</td>
	          <td width="7%">مقدار باطله</td> 	  
	          <td width="10%">مقدار اولیه مجوز</td>
	          <td width="8%">مقدار تحویلی از مجوز</td>	  
	         <!--<td width="%">مقدار مانده از حواله </td>--> 
	        </tr>';	 
	  } 
	}
	echo'
   </table>

 <!--پايان مرکز صفحه -->
 <!-- چاپ زیرنویس-->
 <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474"> 
  <tr class="print_footer">
   <td colspan="3">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
  </tr>
 </table>
</body>
</html>';	
?>