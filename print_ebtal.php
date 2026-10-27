<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_ebtal.php";
if($_SESSION['mt_systemforush']==0){$TableName="ebtal";}//اطلاعات ابطال از سیستم انبار
if($_SESSION['mt_systemforush']==1)//اطلاعات ابطال از سیستم فروش
{
 mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());
 $TableName="dm_ebtal_h";
 //پیدا کردن آی دی کد استان مربوط به سیتم فروش
  $res_ostan=mysql_query("SELECT province_id FROM dm_province WHERE province_code='$mt_gl_code_ostan'");
  $sell_id_ostan=mysql_result($res_ostan, 0, 'province_id');
 //پیدا کردن آی دی کد انبار مربوط به سیستم فروش
  $res_anbar=mysql_query("SELECT l_id FROM dm_location_goods WHERE l_code='$mt_gl_code_anbar'");
  $sell_id_anbar=mysql_result($res_anbar, 0, 'l_id');
 //پیدا کردن آی دی سال مربوط به سیستم فروش
  $sellYearCode=substr($mtActiveYear,2);
  $res_sal=mysql_query("SELECT year_id FROM dm_year WHERE year_code='$sellYearCode'");
  $sellYearId=mysql_result($res_sal, 0, 'year_id');
}
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$count=1;
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>چاپ ابطال مقادیر حواله فروش</title>
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
    <tr><td class="print_title_2">جدول ابطال مقادیر حواله فروش&nbsp&nbsp(صفحه : 1)
	    <span style="float:right"><a href="javascript:window.print();"><img src="images/PrinterText.png" onmouseOver="this.src=\'images/PrinterText-hover.png\'" onmouseOut="this.src=\'images/PrinterText.png\'" title="چاپ" id="IMG1" class="hideatprint"/></a></span>
		</td>
	</tr>
   </table>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
  <tr class="print_table-title2">
	  <td width="5%">رديف</td>
	  <td width="10%">شماره برگه ابطال</td> 
	  <td width="10%">تاریخ برگه ابطال</td>
	  <td width="10%">شماره مجوز </td> 	  
	  <td width="10%">شماره حواله فروش</td> 
	  <td width="10%">تاریخ حواله فروش</td> 
	  <td width="8%">کد مشتری</td> 
	  <td width="7%">کد کالا</td>
	  <td width="10%">مقدار باطله </td> 	  
	  <td width="10%">مقدار اولیه حواله فروش</td>
	  <td width="10%">مقدار تحویلی از حواله </td>	  
	  <!--<td width="%">مقدار مانده از حواله </td>--> 	 
   </tr>';
//نمایش اطلاعات در حالت سیستم انبار	
  if($_SESSION['mt_systemforush']==0)
  {
   $page=1;
   $line=0;
   $i=0;$cntr=0;
   $MaxLines=20;
   $q1="SELECT T.*,h_f.h_code,h_f.h_reg_date,h_f.meghdar_havale_forush,h_f.code_kala,h_f.code_customer
         FROM $TableName T INNER JOIN havale_forush h_f ON h_f.h_code=T.h_code AND h_f.code_ostan=T.code_ostan AND h_f.code_anbar=T.code_anbar AND h_f.year=T.year
	    WHERE T.tarikh_barge_ebtal>='$mtStartDateSh' AND h_f.h_reg_date>='$mtStartDateSh' AND T.code_ostan='$mt_gl_code_ostan' and T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0 order by T.id asc";
   $allEbtal = $db->query($q1);
   $cntr =mysql_num_rows($allEbtal);
   while($row1=$db->fetch_assoc($allEbtal))
   { 
    $q20="SELECT SUM(vazn_khales_h) FROM havale WHERE h_code='".$row1['h_code']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0";//محاسبه مقدار تحویلی
    $res20=mysql_query($q20);
    $meghdar_tahvily=mysql_fetch_array($res20);
    // $q21="SELECT SUM(meghdar_batele) FROM ebtal WHERE h_code='".$row1['h_code']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0";//محاسبه مقدار باطله
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
	  <td>'.$code_a.$row1['code_anbar'].$row1['shomare_barge_ebtal'].'</td>
	  <td>'.$row1['tarikh_barge_ebtal'].'</td>
	  <td>'.$row1['shomare_mojavez_ebtal'].'</td>  
	  <td>'.$row1['h_code'].'</td>
	  <td>'.$row1['h_reg_date'].'</td>
	  <td>'.$row1['code_customer'].'</td>
	  <td>'.$row1['code_kala'].'</td>
	  <td>'.($row1['meghdar_batele']).'</td>
	  <td>'.($row1['meghdar_havale_forush']).'</td>
	  <td>'.($meghdar_tahvily[0]).'</td>	  	  
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
            <tr><td class="print_title_2">جدول ابطال مقادیر حواله فروش&nbsp&nbsp(صفحه : '.$page.')
	        	</td>
	        </tr>
           </table>
		   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
		    <tr class="print_table-title2">
	         <td width="5%">رديف</td>
	         <td width="10%">شماره برگه ابطال</td> 
	         <td width="10%">تاریخ برگه ابطال</td>
	         <td width="10%">شماره مجوز </td> 	  
	         <td width="10%">شماره حواله فروش</td> 
	         <td width="10%">تاریخ حواله فروش</td> 
	         <td width="8%">کد مشتری</td> 
	         <td width="7%">کد کالا</td>
	         <td width="10%">مقدار باطله </td> 	  
	         <td width="10%">مقدار اولیه حواله فروش</td>
	         <td width="10%">مقدار تحویلی از حواله </td>	  
	         <!--<td width="%">مقدار مانده از حواله </td>--> 
			</tr>';	 
	  } 
	}//END while
  }
//نمایش اطلاعات در حالت سیستم فروش	
 if($_SESSION['mt_systemforush']==1)
  {
   $page=1;
   $line=0;
   $i=0;$cntr=0;
   $MaxLines=20;
   $q1="SELECT dm_ebtal_h.ebh_code,dm_ebtal_h.ebh_reg_date,dm_his_havale.his_h_code,dm_his_havale.his_eb_amount,dm_havale.h_code,dm_havale.h_reg_date,
	    dm_havale.h_customer_code,dm_havale.h_p_code,dm_havale.h_amount
		FROM dm_ebtal_h  
		INNER JOIN dm_his_havale ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id 
		INNER JOIN dm_havale ON dm_havale.h_id=dm_his_havale.his_h_id 
		WHERE dm_ebtal_h.ebh_reg_date>='$mtStartDateMi' AND dm_havale.h_reg_date>='$mtStartDateMi' AND dm_his_havale.his_id_province='$sell_id_ostan' AND dm_his_havale.his_l_code='$sell_id_anbar' AND dm_his_havale.his_id_year='$sellYearId' order by ebh_id desc";
   $allEbtal = $db->query($q1);
   $cntr =mysql_num_rows($allEbtal);
   while($row1=$db->fetch_assoc($allEbtal))
   {
	//تبدیل تاریخ میلادی به شمسی
	$sql_tarikh_ebtal=$row1['ebh_reg_date'];//تاریخ ابطال
    $d=substr($sql_tarikh_ebtal,8,2);
    $m=substr($sql_tarikh_ebtal,5,2);
    $y=substr($sql_tarikh_ebtal,0,4);
    $shamsi=gregorian_to_jalali($y,$m,$d);
    $sal=$shamsi[0];
    $mah=$shamsi[1];
    $rouz=$shamsi[2];
    $tarikh_ebtal=$sal.'/'.$mah.'/'.$rouz;
	$sql_tarikh_havale=$row1['h_reg_date'];//تاریخ حواله فروش
    $d=substr($sql_tarikh_havale,8,2);
    $m=substr($sql_tarikh_havale,5,2);
    $y=substr($sql_tarikh_havale,0,4);
    $shamsi=gregorian_to_jalali($y,$m,$d);
    $sal=$shamsi[0];
    $mah=$shamsi[1];
    $rouz=$shamsi[2];
    $tarikh_h_forush=$sal.'/'.$mah.'/'.$rouz;
    //محاسبه مقدار تحویلی در هر دو سیستم یکسان است    
	     mysql_select_db($mydatabase) or die('no Select Db BECAUSE: ' . mysql_error());	  
         $q20=("SELECT SUM(vazn_khales_h) FROM havale WHERE h_code='".$row1['h_code']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");
	     $res20=mysql_query($q20);
         $meghdar_tahvil=mysql_fetch_array($res20);
         $meghdar_tahvily=$meghdar_tahvil[0];
	 //پایان محاسبه مقدار تحویلی
     mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());	
     $line++;
     if($i++%2) echo'<tr class="print_table-odd"/>';
     else echo '<tr class="print_table-even"/>';
     echo'
	  <td>'.$count++.'</td>
	  <td>'.$row1['ebh_code'].'</td>
	  <td>'.$tarikh_ebtal.'</td>
	  <td>'.$row1['his_h_code'].'</td>
	  <td>'.$tarikh_h_forush.'</td>
	  <td>'.$row1['h_customer_code'].'</td>
	  <td>'.$row1['h_p_code'].'</td>
	  <td>'.($row1['his_eb_amount']).'</td>
	  <td>'.($row1['h_amount']).'</td>
	  <td>'.($meghdar_tahvily).'</td>	  
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
            <tr><td class="print_title_2"> انبار : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
            <tr><td class="print_title_2">جدول ابطال مقادیر حواله فروش&nbsp&nbsp(صفحه : '.$page.')
	        	</td>
	        </tr>
           </table>
		   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
		    <tr class="print_table-title2">
	         <td width="5%">رديف</td>
	         <td width="10%">شماره برگه ابطال</td> 
	         <td width="10%">تاریخ برگه ابطال</td>
	         <td width="10%">شماره مجوز </td> 	  
	         <td width="10%">شماره حواله فروش</td> 
	         <td width="10%">تاریخ حواله فروش</td> 
	         <td width="8%">کد مشتری</td> 
	         <td width="7%">کد کالا</td>
	         <td width="10%">مقدار باطله </td> 	  
	         <td width="10%">مقدار اولیه حواله فروش</td>
	         <td width="10%">مقدار تحویلی از حواله </td>	  
	         <!--<td width="%">مقدار مانده از حواله </td>--> 	 
			</tr>';	 
	  } 
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